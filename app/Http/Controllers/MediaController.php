<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Clientele;
use App\Models\CoreValue;
use App\Models\CustomPage;
use App\Models\Event;
use App\Models\HomeBanner;
use App\Models\JobApplication;
use App\Models\NewsPost;
use App\Models\Review;
use App\Models\Service;
use App\Models\StaticInformation;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidConversion;

class MediaController extends Controller
{
    protected $imageManager;

    protected $mediaModelsToBeRestrict = [
        'businessDocumentTransactions',
        'emailTemplates',
        'emails'
    ];

    public function __construct()
    {
        $this->middleware('cache.headers:private;max_age=2592000;etag');
        $this->middleware('auth')->except(['getDefaultImage']);
        $this->imageManager = new ImageManager(
            driver: new Driver()
        );
    }

    /**
     * Returns default image
     *
     * @param string $resolution
     * @param string $type
     * @return mixed
     */
    public function getDefaultImage($resolution = "", $type = "")
    {
        $resolution = $resolution != "" ? ("_" . $resolution) : "";
        $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/default/default-image' . $resolution . '.jpg');

        if (!empty($type)) {
            switch ($type) {
                case '404':
                    $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/404/default-image-404' . $resolution . '.jpg');
                    break;
                default:
                    $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/404/default-image-404' . $resolution . '.jpg');
            }
        }

        $image = $this->imageManager->read($complete_path);
        return response($image->encode())->header('Content-Type', 'image/jpeg');
    }

    public function responseImage($model, $modelUuid, $collection, $mediaId, $conversion, $name)
    {
        $modelObject = $this->getModelInstance($model)->findWithUuid($modelUuid);

        if (is_null($modelObject)) {
            return abort(404);
        }

        $media = $modelObject->getMedia($collection)->where('id', $mediaId)->first();

        if (!$media || $media->name != $name) {
            return abort(404);
        }

        try {
            $conversion = $conversion == "NoC" ? "" : $conversion;  // NoC ~ NoConversion
            $complete_path = $media->getPath($conversion);

            if (file_exists($complete_path)) {
                $image = $this->imageManager->read($complete_path);
                return response($image->encode())->header('Content-Type', $media->mime_type);
            } else {
                return $this->getDefaultImage($this->getDefaultImageResolutionFromConversion($conversion), '404');
            }
        } catch (InvalidConversion $e) {
            Log::info("[MODEL OBJECT#$modelObject->id][COLLECTION $collection][CONVERSION $conversion]MEDIA #$media->id] Invalid Conversion");
            return abort(404);
        }
    }

    public function response($model, $modelUuid, $collection, $mediaId, $name)
    {
        $modelObject = $this->getModelInstance($model)->findWithUuid($modelUuid);

        if (is_null($modelObject)) {
            return abort(404);
        }

        $media = $modelObject->getMedia($collection)->where('id', $mediaId)->first();

        if (!$media || $media->name != $name) {
            return abort(404);
        }

        try {
            $complete_path = $media->getPath();
            if (file_exists($complete_path)) {
                if ($media->mime_type === "application/pdf") {
                    return response()->file($complete_path);
                } else {
                    return response()->download($complete_path);
                }
            } else {
                return abort(404);
            }
        } catch (\Exception $e) {
            Log::info("[OTHER MEDIA][MODEL OBJECT#$modelObject->id][COLLECTION $collection][MEDIA #$media->id] Exception: " . $e->getMessage());
            return abort(404);
        }
    }


    public function getModelInstance($model = 'users'){
        if($model === 'users'){
            return (new User());
        }
        return (new User());
    }

    protected function getDefaultImageResolutionFromConversion($conversion = 'NoC')
    {
        return match ($conversion) {
            'NoC' => '500x500',
            'thumb_50x50' => '50x50',
            'thumb_100x100' => '100x100',
            'thumb_250x250' => '250x250',
            'thumb_500x500' => '500x500',
            'thumb_1024x1024' => '1024x1024',
            'thumb_1500x1500' => '1500x1500',
            default => '500x500',
        };
    }

    public function responseMedia($model, $collection, $mediaId, $fileName)
    {
        $path = $this->getMediaPath($model, $collection, $mediaId, $fileName);
        $image = $this->imageManager->read($path);
        return response($image->encode())->header('Content-Type', $this->getMimeType($path));
    }

    public function responseResponsiveMedia($model, $collection, $mediaId, $fileName)
    {
        $path = $this->getMediaPath($model, $collection, $mediaId, 'responsive-images/' . $fileName);
        $image = $this->imageManager->read($path);
        return response($image->encode())->header('Content-Type', $this->getMimeType($path));
    }

    public function responseConversions($model, $collection, $mediaId, $fileName)
    {
        $path = $this->getMediaPath($model, $collection, $mediaId, 'conversions/' . $fileName);
        $image = $this->imageManager->read($path);
        return response($image->encode())->header('Content-Type', $this->getMimeType($path));
    }

    protected function getMediaPath($model, $collection, $mediaId, $fileName)
    {
        return config('filesystems.disks.localStore.root')
            . DIRECTORY_SEPARATOR . 'media'
            . DIRECTORY_SEPARATOR . $model
            . DIRECTORY_SEPARATOR . $collection
            . DIRECTORY_SEPARATOR . $mediaId
            . DIRECTORY_SEPARATOR . $fileName;
    }

    protected function getMimeType($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return match (strtolower($extension)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
        };
    }
}

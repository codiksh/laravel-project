<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Facades\Response;

use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Interfaces\EncodedImageInterface;

use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidConversion;

class MediaController extends Controller
{

    protected $mediaModelsToBeRestrict = [

    ];

    public function __construct()
    {
        $this->middleware('cache.headers:private;max_age=2592000;etag');
        if (in_array(request()->route('model'), $this->mediaModelsToBeRestrict))
            $this->middleware('auth')->except(['getDefaultImage']);
    }


    /**
     * Returns default image
     *
     * @param string $resolution
     * @param string $type
     * @return mixed
     */
    public function getDefaultImage($resolution = "",$type = ""){
        $manager = new ImageManager(new Driver());

        $resolution = $resolution != "" ? ("_" . $resolution) : "";
        $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/default/default-image' . $resolution . '.jpg');
        if (!empty($type)) {
            switch ($type){
                case '404':
                    $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/404/default-image-404' . $resolution . '.jpg');
                    break;
                default:
                    $complete_path = resource_path('assets' . DIRECTORY_SEPARATOR . 'images/404/default-image-404' . $resolution . '.jpg');
            }
        }

        $image = $manager->read($complete_path);

        // $mime_type = mime_content_type($complete_path);
        $mime_type = $this->getMimeType($complete_path);

        switch ($mime_type) {
            case 'image/jpeg':
                $contents = $image->toJpeg()->toString();
                break;
            case 'image/png':
                $contents = $image->toPng()->toString();
                break;
            case 'image/gif':
                $contents = $image->toGif()->toString();
                break;
            default:
                $contents = $image->toJpeg()->toString();
                $mime_type = 'image/jpeg';
        }

        return Response::make($contents, 200, [
            'Content-Type' => $mime_type,
            'Content-Length' => strlen($contents),
        ]);
    }


    public function responseImage($model, $modelUuid, $collection, $mediaId, $conversion, $name)
    {
        $modelObject = $this->getModelInstance($model)
            ->withoutGlobalScopes([ProfessionalScope::class, OnlyFromSelfProfessionalScope::class])
            ->findWithUuid($modelUuid);

        if (is_null($modelObject)) {
            return abort(404);
        }

        $media = $modelObject->getMedia($collection)->where('id', $mediaId)->first();

        if (!$media || $media->name != $name) {
            return abort(404);
        }

        $manager = new ImageManager(new Driver());

        try {
            $conversion = $conversion == "NoC" ? "" : $conversion;  // NoC ~ NoConversion
            $complete_path = $media->getPath($conversion);
            $complete_path = str_replace('\\', '/', $complete_path);

            if (file_exists($complete_path)) {
                $image = $manager->read($complete_path);

                // Determine the MIME type based on the file extension
                $mime_type = $this->getMimeType($complete_path);

                // Encode the image
                $encoded_image = $image->encode();

                if ($encoded_image instanceof EncodedImageInterface) {
                    return Response::make($encoded_image->__toString(), 200, [
                        'Content-Type' => $mime_type,
                        'Content-Disposition' => 'inline; filename="' . $name . '"'
                    ]);
                } else {
                    throw new \Exception('Failed to encode image');
                }
            } else {
                return $this->getDefaultImage($this->getDefaultImageResolutionFromConversion($conversion), '404');
            }
        } catch (\Exception $e) {
            Log::error("[MODEL OBJECT#{$modelObject->id}][COLLECTION {$collection}][CONVERSION {$conversion}]MEDIA #{$media->id}] Error: " . $e->getMessage());
            return abort(404);
        }
    }


    public function response($model, $modelUuid, $collection, $mediaId, $name){
        $modelObject = $this->getModelInstance($model)->findWithUuid($modelUuid);

        //Some basic level validations
        $media = $modelObject->getMedia($collection)->where('id',$mediaId)->first();
        if(is_null($modelObject)){
            return abort(404);
        }
        if(!$media || $media->name != $name){
            return abort(404);
        }
        try {
            $complete_path = $media->getPath();
            if (file_exists($complete_path)) {
                if ($media->mime_type === "application/pdf")
                    return response()->file($complete_path);
                else
                    return response()->download($complete_path);
            } else {
                return abort(404);
            }
        }catch (\Exception $e){
            Log::info("[OTHER MEDIA][MODEL OBJECT#$modelObject->id][COLLECTION $collection][MEDIA #$media->id] Some Exception caught " . $e);
            return abort(404);
        }
    }


    public function getModelInstance($model = 'users'){
        if($model === 'users'){
            return (new User());
        }
        // if($model === 'si'){
        //     return (new StaticInformation());
        // }
        // if($model === 'services'){
        //     return (new Service());
        // }
        // if($model === 'clienteles'){
        //     return (new Clientele());
        // }
        // if($model === 'reviews'){
        //     return (new Review());
        // }
        // if($model === 'professionals'){
        //     return (new Professional());
        // }
        // if($model === 'portfolios'){
        //     return (new Portfolio());
        // }
        return (new User());
    }


    public function getDefaultImageResolutionFromConversion($conversion = 'NoC'){
        switch($conversion){
            case 'NoC': return '500x500';
            case 'thumb_50x50': return '50x50';
            case 'thumb_100x100': return '100x100';
            case 'thumb_250x250': return '250x250';
            case 'thumb_500x500': return '500x500';
            case 'thumb_1024x1024': return '1024x1024';
            case 'thumb_1500x1500': return '1500x1500';
            default: return '500x500';
        }
    }


    public function responseMedia($model, $collection, $mediaId, $fileName)
    {
        $path = env('CUSTOM_LOCAL_STORE_PATH') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $model
            . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR . $mediaId . DIRECTORY_SEPARATOR . $fileName;

        return $this->createImageResponse($path, $fileName);
    }

    public function responseResponsiveMedia($model, $collection, $mediaId, $fileName)
    {
        $path = env('CUSTOM_LOCAL_STORE_PATH') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $model
            . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR . $mediaId . DIRECTORY_SEPARATOR
            . 'responsive-images' . DIRECTORY_SEPARATOR . $fileName;

        return $this->createImageResponse($path, $fileName);
    }

    private function createImageResponse($path, $fileName)
    {
        if (!file_exists($path)) {
            return abort(404);
        }

        $manager = new ImageManager(new Driver());

        try {
            $image = $manager->read($path);
            $mime_type = $this->getMimeType($path);

            $encoded_image = $image->encode();

            if ($encoded_image instanceof EncodedImageInterface) {
                return Response::make($encoded_image->__toString(), 200, [
                    'Content-Type' => $mime_type,
                    'Content-Disposition' => 'inline; filename="' . $fileName . '"'
                ]);
            } else {
                throw new \Exception('Failed to encode image');
            }
        } catch (\Exception $e) {
            Log::error("Error processing image {$path}: " . $e->getMessage());
            return abort(404);
        }
    }

    private function getMimeType($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mime_types = [
            // Image types
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'webp' => 'image/webp',
            // Video types
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'flv' => 'video/x-flv',
            'mov' => 'video/quicktime',
            'mkv' => 'video/x-matroska',
            'webm' => 'video/webm',
            '3gp' => 'video/3gpp',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
        ];
        return $mime_types[strtolower($extension)] ?? 'application/octet-stream';
    }
}

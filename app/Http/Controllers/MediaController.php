<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidConversion;

class MediaController extends Controller
{

    protected $mediaModelsToBeRestrict = [
        'businessDocumentTransactions',
        'emailTemplates',
        'emails'
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
        return Image::make($complete_path)->response();
    }


    public function responseImage($model, $modelUuid, $collection, $mediaId, $conversion, $name){
        $modelObject = $this->getModelInstance($model)->findWithUuid($modelUuid);

        //Some basic level validations
        $media = $modelObject->getMedia($collection)->where('id',$mediaId)->first();
        if($media->name != $name){
            return abort(404);
        }
        if(is_null($modelObject)){
            return abort(404);
        }

        try {
            $conversion = $conversion == "NoC" ? "" : $conversion;  // NoC ~ NoConversion
            $complete_path = $media->getPath($conversion);
            if(file_exists($complete_path)){
                return Image::make($complete_path)->response();
            }else{
                return $this->getDefaultImage($this->getDefaultImageResolutionFromConversion($conversion),'404');
            }
        }catch (InvalidConversion $e){
            Log::info("[MODEL OBJECT#$modelObject->id][COLLECTION $collection][CONVERSION $conversion]MEDIA #$media->id] Invalid Conversion");
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


    public function responseMedia($model,$collection,$mediaId,$fileName) {
        $path =  env('CUSTOM_LOCAL_STORE_PATH') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $model
            . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR . $mediaId . DIRECTORY_SEPARATOR . $fileName;
//        return $path;
        return Image::make($path)->response();
    }
    public function responseResponsiveMedia($model,$collection,$mediaId,$fileName) {
        $path =  env('CUSTOM_LOCAL_STORE_PATH') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $model
            . DIRECTORY_SEPARATOR . $collection . DIRECTORY_SEPARATOR . $mediaId . DIRECTORY_SEPARATOR
            . 'responsive-images' . DIRECTORY_SEPARATOR . $fileName;
//        return $path;
        return Image::make($path)->response();
    }

}

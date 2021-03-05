<?php

/**
 * Created by PhpStorm.
 * User: Nikhil
 * Date: 21-Jun-19
 * Time: 15:39
 */

namespace App\Overrides\LaravelMediaLibrary;

use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media) : string
    {

        return "media" . DIRECTORY_SEPARATOR . $this->getModelDirectory($media->model_type) . $this->getCollectionDirectory($media->collection_name)
            . $media->id . DIRECTORY_SEPARATOR;
    }
    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media) . 'conversions' . DIRECTORY_SEPARATOR;
    }
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }


    public function getModelDirectory($model){
        if($model === User::class){
            return "users" . DIRECTORY_SEPARATOR;
        }
        return "";
    }
    public function getCollectionDirectory($collection){
        return $collection . DIRECTORY_SEPARATOR;
    }
}

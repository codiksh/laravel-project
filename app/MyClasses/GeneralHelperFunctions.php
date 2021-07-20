<?php

/**
 * Author: Nikhil Bhatia
 * TimeStamp: 2020-04-28 17:02 IST
 */

namespace App\MyClasses;


use App\Models\Clientele;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Task;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GeneralHelperFunctions {

    /**
     * Updates or Creates Single Media files like avatar for models.
     *
     * @param Model $modelRecord
     * @param Request $request
     * @param string $inputFileName
     * @param string $collection
     * @param string $defaultMediaPath
     * @param bool $isDefaultMediaPathUrl
     * @return Media | bool
     */
    public static function updateOrCreate_singleMedia(Model $modelRecord, Request $request, $inputFileName = 'avatar', $collection = 'avatar', $defaultMediaPath = null, $isDefaultMediaPathUrl = false){
        if($request->hasFile($inputFileName)) {
            $hashedName = $request->file($inputFileName)->hashName();
            return $modelRecord->addMedia($request->{$inputFileName})
                ->setName($hashedName)
                ->setFileName($hashedName)
                ->withResponsiveImages()
                ->toMediaCollection($collection);
        }

        if(is_null($defaultMediaPath)) {
            if ($request->has($inputFileName . 'Deleted') && (int)$request->input($inputFileName . 'Deleted')) {
                $modelRecord->clearMediaCollection($collection);
            }
        }else{
            if(($request->has($inputFileName . 'Deleted') && $request->boolean($inputFileName . 'Deleted'))
                || ($request->has('provideDefault' . Str::ucfirst($inputFileName)) && $request->boolean('provideDefault' . Str::ucfirst($inputFileName)))){
                return self::updateOrCreate_defaultMedia($modelRecord, $defaultMediaPath, $collection, $isDefaultMediaPathUrl);
            }
        }

        return true;
    }


    /**
     * Sets Default Media to Single Media Collection
     *
     * @param Model $modelRecord
     * @param string $defaultMediaPath
     * @param string $collection
     * @param bool $isMediaUrl
     * @return Media
     */
    public static function updateOrCreate_defaultMedia(Model $modelRecord, $defaultMediaPath, $collection, $isMediaUrl = false) {
        if(!$isMediaUrl) {
            $file = $defaultMediaPath;
            $pathInfo = pathinfo($file);
            $hashedName = md5($pathInfo['filename']) . '.' . $pathInfo['extension'];
            return $modelRecord->copyMedia($file)
                ->setName($hashedName)
                ->setFileName($hashedName)
                ->withResponsiveImages()
                ->toMediaCollection($collection);
        }

        return $modelRecord->addMediaFromUrl($defaultMediaPath)
            ->withResponsiveImages()
            ->toMediaCollection($collection);
    }



    /**
     * Returns basic Single Media Urls for Models of thumb_100x100, thumb_250x250 and NoC
     *
     * @param Model $modelRecord
     * @param $model
     * @param string $collection
     * @return mixed
     */
    public static function getSingleMediaUrls(Model $modelRecord, $model, $collection = 'avatar') {
        if($modelRecord->hasMedia($collection)) {
            $avatar = $modelRecord->getFirstMedia($collection);
            $avatarUrl["100"] = route('media_images', [
                'model' => $model,
                'modelUuid' => $modelRecord->uuid,
                'collection' => $collection,
                'mediaId' => $avatar->id,
                'conversion' => 'thumb_100x100',
                'name' => $avatar->name,
            ]);
            $avatarUrl["250"] = route('media_images', [
                'model' => $model,
                'modelUuid' => $modelRecord->uuid,
                'collection' => $collection,
                'mediaId' => $avatar->id,
                'conversion' => 'thumb_250x250',
                'name' => $avatar->name,
            ]);
            $avatarUrl["NoC"] = route('media_images', [
                'model' => $model,
                'modelUuid' => $modelRecord->uuid,
                'collection' => $collection,
                'mediaId' => $avatar->id,
                'conversion' => 'NoC',
                'name' => $avatar->name,
            ]);
        }else{
            $avatarUrl["100"] = route('images_default',['resolution' => '100x100', 'type' => '404']);
            $avatarUrl["250"] = route('images_default',['resolution' => '250x250', 'type' => '404']);
            $avatarUrl["NoC"] = route('images_default',['resolution' => '1024x1024', 'type' => '404']);
        }
        return $avatarUrl;
    }

    /**
     * Generates SEO for given information
     *
     * @param null $title
     * @param null $description
     * @param array $images
     * @param array $keywords
     * @param null $url
     * @param null $canonicalUrl
     * @param array $properties
     */
    public static function setSeo($title = null, $description = null, $images = [], $keywords = [], $url = null, $canonicalUrl = null, $properties = []) {
        if(!is_null($title) && !empty($title))    SEOTools::setTitle("$title");
        if(!is_null($description) && !empty($description))    SEOTools::setDescription($description);
        if(!is_null($url)  && !empty($url))    SEOTools::opengraph()->setUrl($url);
        if(!is_null($canonicalUrl)  && !empty($canonicalUrl))    SEOTools::setCanonical($canonicalUrl);
        if(!is_null($properties)  && !empty($properties) && sizeof($properties) > 0){
            foreach ($properties as $key => $value) {
                SEOTools::opengraph()->addProperty($key, $value);
            }
        }
        if(!is_null($images) && !empty($images) && sizeof($images) > 0){
            SEOTools::opengraph()->addImage($images[0]);
            foreach ($images as $keyword) {
                SEOTools::jsonLd()->addImage($keyword);
            }
        }
        if(!is_null($keywords) && !empty($keywords) && sizeof($keywords) > 0){
            foreach ($keywords as $keyword) {
                SEOTools::metatags()->addKeyword($keyword);
            }
        }
    }

    public static function applyCategoryRelationFilterOnQuery_fromRequest(Builder $QUERY, Request $request) {
        if(request()->has('category') && !empty(request()->input('category'))) {
            $QUERY->whereHas('category', function ($QUERY) {
                $QUERY->where('uuid', request()->input('category'));
            });
        }
        if(request()->has('url_category') && !empty(request()->input('url_category'))) {
            $QUERY->whereHas('category', function ($QUERY) {
                $QUERY->where('uuid', request()->input('url_category'));
            });
        }
        return $QUERY;
    }


    /**
     * Adds all attachment files to the media library.
     * @param Model $record
     * @param Request $request
     * @param $requestInputName
     * @param $collectionName
     */
    public static function addFilesFromRequest_toMediaCollection_ofModel(Model $record, Request $request, $requestInputName, $collectionName) {
        if($request->hasFile($requestInputName)){
            foreach ($request->file($requestInputName) as $file) {
                $record->addMedia($file)
                    ->toMediaCollection($collectionName);
            }
        }
    }


    /**
     * Returns HTML for Editing created record or registering another
     * @param $record
     * @param null $editRoute
     * @param string $nameField
     * @param null $editText
     * @param string $regAnotherText
     * @return string
     */
    public static function getSuccessResponseBtn($record = null,$editRoute = null,$nameField = 'name', $editText = null, $regAnotherText = 'Register Another?'){
        $regAnotherBtnHtml = '';
        $editBtnHtml = '';
        if(!is_null($record)) {
            if (!is_null($editRoute)) {
                $editText = !is_null($editText) ? $editText : (!is_null($nameField) ? 'Edit ' . $record->{$nameField} : 'Edit');
                $editBtnHtml = "<a href='" . $editRoute . "' class='btn btn-secondary m-t-5 rspSuccessBtns' role='button'>" . $editText . "</a>";
            }
        }
        if(!is_null($regAnotherText)) {
            $regAnotherBtnHtml = "<button type='button' class='btn m-t-5 btn-primary rspSuccessBtns' onclick='switch_between_register_to_registerAnother_btn($(\".submitsByAjax\"), true)'>$regAnotherText</button>";
        }
        return "<hr class='m-t-5 m-b-5'>
                <div>
                    $editBtnHtml
                    $regAnotherBtnHtml
                </div>";
    }


    /**
     * Returns model's id from given uuid and builder for the model
     * @param Builder $builder
     * @param $uuid
     * @return int |null
     */
    public static function getModelIdFromUuid(Builder $builder, $uuid) {
        $record = $builder->whereUuid($uuid)->first();
        return $record ? $record->id : null;
    }

    //=======   Mails/SMS transaction ==========

    /**
     * Returns table name of mailable/messagable
     * @return string
     */
    public static function getTransactionableTableName() {
        return Str::plural(request()->route('type'));
    }

    /**
     * Gets the query instance for the mailable/messagable/commentable.
     * @param string $returnType => query or class
     * @return Clientele|Lead|\Illuminate\Database\Eloquent\Builder|string|null
     */
    public static function getTransactionableQueryOrInstance_forRequest($returnType = 'query') {
        switch (request()->route('type')){
            case 'lead' : return $returnType == 'query' ? Lead::query() : Lead::class;
            case 'clientele' : return $returnType == 'query' ? Clientele::query() : Clientele::class;
            case 'task' : return $returnType == 'query' ? Task::query() : Task::class;
            case 'project' : return $returnType == 'query' ? Project::query() : Project::class;
            default: return null;
        }
    }

    /**
     * Applies pagination to the query
     * @param Request $request
     * @param Builder $QUERY
     * @return mixed
     */
    public static function applyPaginationToTheQuery(Request $request, $QUERY) {
        if(isset($request->pageNo) && isset($request->noOfRecords) && !empty($request->pageNo) && !empty($request->noOfRecords)) {
            $skip = (int)(($request->pageNo - 1) * $request->noOfRecords);
            $QUERY->skip((int)$skip)->limit((int)$request->noOfRecords);
        }
        return $QUERY;
    }


    /**
     * A certain format is required for select with default listing, this format is built by this function.
     * @param $results
     * @param $term
     * @param $totalRecordCount
     * @param Request|null $request
     * @param $paginateForSearch
     * @return array
     */
    public static function prepareSelect2Response_forDefaultListing($results, $term, $totalRecordCount, Request $request = null, $paginateForSearch = false) {
        $request = $request ?? request();
        $response = [
            'results' => $results,
        ];
        if($term == '' || $paginateForSearch){
            $response['pagination'] = [
                'more' => $request->input('pageNo') * $request->input('noOfRecords') < $totalRecordCount
            ];
        }
        return $response;
    }


    /**
     * Prepares Date time string from the request when date and time are separately provided in the request.
     * @param Request $request
     * @param $dateVarName
     * @param $timeVarName
     * @param string $dateFormat
     * @param string $timeFormat
     * @return string|null
     */
    public static function prepareDateTimeString_fromReq(Request $request, $dateVarName, $timeVarName = null,
                                                         $dateFormat = 'd/m/Y', $timeFormat = 'H:i') {
        $dateTimeString = '';
        if($request->has($dateVarName) && !empty($request->input($dateVarName)) && !is_null($request->input($dateVarName))){
            $dateTimeString .= Carbon::createFromFormat($dateFormat, $request->input($dateVarName))->toDateString();
            if(!is_null($timeVarName) && $request->has($timeVarName) && !empty($request->input($timeVarName)) && !is_null($request->input($timeVarName))){
                $dateTimeString .= ' ' . Carbon::createFromFormat($timeFormat, $request->input($timeVarName))->toTimeString();
            }
        }

        return $dateTimeString == '' ? null : $dateTimeString;
    }


    /**
     * Deletes Model records one by one, so that their delete event is triggered.
     * @param $recordsToDelete
     */
    public static function deleteModelRecordsOneByOne($recordsToDelete) {
        foreach ($recordsToDelete as $item) {
            $item->delete();
        }
    }

    /**
     * Counts Sundays between dates.
     * @param $start
     * @param $end
     * @return int
     */
    public static function countSundaysBetweenDates($start, $end) {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        return $start->diffInDaysFiltered(function (Carbon $date) {
            return $date->isSunday();
        }, $end);
    }

    /**
     * Calculates the change in percentage over two values.
     * @param $new
     * @param $old
     * @return string
     */
    public static function calculateChangePercentage($new, $old) {
        if($old == 0)   return $new * 100;
        return round((($new-$old)/$old), 2) * 100;
    }

    /**
     * Prepares HTML date, such that, displaying text is shorter text, while title is detailed text.
     * @param $date
     * @param string $format
     * @return string
     */
    public static function prepareHtmlDate($date, $format = 'Y-m-d H:i:s') {
        if(is_null($date))  return '';
        try {
            $date = Carbon::parse($date);
        }catch (InvalidFormatException $e){
            $date = Carbon::createFromFormat($format, $date);
        }
        return '<p title="' . $date->toDayDateTimeString() . '">' . $date->format('F d, Y') . '</p>';
    }

    /**
     * Checks if the input is valid uuid.
     * @param $uuid
     * @return bool
     */
    public static function is_uuid($uuid) {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }

    public static function getRulesForArrFilterInputs($rules, $keyName, $required = false, $includeFilterTypes = true) {
        return [
            $keyName => ($required ? 'required' : 'nullable') . '|array',
            "$keyName.*" => ($required ? 'required' : 'nullable') . '|' . $rules,
            "{$keyName}_type" => 'nullable|in:In,NotIn',
        ];
    }

    /**
     * Gets ordinal of given number. like 1st, 2nd, 3rd
     * @param $number
     * @return string
     */
    public static function getOrdinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}

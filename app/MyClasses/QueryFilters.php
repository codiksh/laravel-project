<?php


namespace App\MyClasses;


use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryFilters {

    /**
     * Applies date filter to the query.
     * @param Request $request
     * @param Builder $QUERY
     * @param string $dateColName
     * @return Builder
     */
    public static function applyDateFilters(Request $request, $QUERY, $dateColName = 'starts_at') {
        if(empty($dateColName))     return $QUERY;
        if($request->has('from_date') && !is_null($request->input('from_date'))){
            $QUERY = $QUERY->where($dateColName, '>=', $request->input('from_date'));
        }
        if($request->has('to_date') && !is_null($request->input('to_date'))){
            $QUERY = $QUERY->where($dateColName, '<=', $request->input('to_date'));
        }
        return $QUERY;
    }


    /**
     * Applies Generic Relation Filter
     * @param Request $request
     * @param Builder $QUERY
     * @param string $relationName
     * @param string $inputName
     * @param string $filterCol
     * @param string $filterType
     * @return Builder
     */
    public static function applyRelationFilter(Request $request, Builder $QUERY, $relationName, $inputName, $filterCol) {
        if($request->has($inputName) && sizeof($request->input($inputName)) > 0) {
            $filteredArr = $request->input($inputName) ?? [];
            $filterType = self::getFilterType($request, $inputName);
            $QUERY = $QUERY->whereHas($relationName,function(Builder $builder) use ($filteredArr, $filterCol, $filterType){
                $builder->{"where$filterType"}($filterCol, $filteredArr);
            });
        }
        return $QUERY;
    }

    /**
     * Gets filtering type for the array based input if any.
     * @param Request $request
     * @param $inputName
     * @return mixed|string
     */
    public static function getFilterType(Request $request, $inputName) {
        if($request->has("{$inputName}_type")){
            $filterType = $request->input("{$inputName}_type");
            if(in_array($filterType, ['In', 'NotIn']))
                return $filterType;
        }
        return 'In';
    }

}

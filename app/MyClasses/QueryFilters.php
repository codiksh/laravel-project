<?php


namespace App\MyClasses;


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
     * @param string | array $relationName
     * @param string $inputName
     * @param string $filterCol
     * @return Builder
     */
    public static function applyRelationFilter(Request $request, Builder $QUERY, $relationName, $inputName, $filterCol) {
        if($request->has($inputName)) {
            $relations = is_array($relationName) ? $relationName : [$relationName];
            $filteredArr = self::getFilteredArr($request, $inputName);
            if(is_bool($filteredArr) && !$filteredArr)  return $QUERY;
            $filterType = self::getFilterType($request, $inputName);
            $QUERY = $QUERY->where(function(Builder $builder) use ($relations, $filteredArr, $filterCol, $filterType){
                foreach ($relations as $key => $relation) {
                    $builder->{($key == 0 ? 'w' : 'orW') . "hereHas"}($relation,function(Builder $builder) use ($filteredArr, $filterCol, $filterType){
                        $builder->{"where$filterType"}($filterCol, $filteredArr);
                    });
                }
            });
        }
        return $QUERY;
    }

    /**
     * Applies Generic Column Filter
     * @param Request $request
     * @param Builder $QUERY
     * @param string $columnName
     * @param string $inputName
     * @return Builder
     */
    public static function applyColumnFilter(Request $request, Builder $QUERY, $columnName, $inputName) {
        if($request->has($inputName)) {
            $filteredArr = self::getFilteredArr($request, $inputName);
            if(is_bool($filteredArr) && !$filteredArr)  return $QUERY;
            $filterType = self::getFilterType($request, $inputName);
            $QUERY = $QUERY->{"where$filterType"}($columnName, $filteredArr);
        }
        return $QUERY;
    }

    /**
     * Returns prepared filtered arr from request. Also, tells, if the input is valid or not. If not, then it will return false.
     * @param Request $request
     * @param $inputName
     * @return array|bool|mixed
     */
    public static function getFilteredArr(Request $request, $inputName) {
        if(is_countable($request->input($inputName))){
            if(count($request->input($inputName)) <= 0)     return false;
            $filteredArr = ($request->input($inputName) ?? []);
        } else {
            if(is_null($request->input($inputName)))    return false;
            $filteredArr = is_null($request->input($inputName)) ? [] : [$request->input($inputName)];
        }
        return $filteredArr;
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

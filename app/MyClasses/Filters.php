<?php


namespace App\MyClasses;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Filters {

    /**
     * Sets filter in the url to session, so that they can be applied in generic way on the target page.
     *
     * HOW IT WORKS:
     * The filters array items may contain three keys: value, isAjaxS2, searchClass. While, the items are keyed by filter names.
     * Following is the sample,
     * [
     *      'user' => [
     *              'value' => 'f87f4220-a913-11eb-8014-a584fb21a3a1',
     *              'ajaxS2-modelType' => 'user'
     *       ],
     *      'from-date' => '20/05/2021',
     *      'to-date' => [
     *              'value' => '29/05/2021',
     *       ],
     * ],
     * More details at: https://teams.microsoft.com/l/entity/com.microsoft.teamspace.tab.wiki/tab::18a124c3-bb51-4d26-ae65-7f6487b68140?context=%7B%22subEntityId%22%3A%22%7B%5C%22pageId%5C%22%3A3%2C%5C%22origin%5C%22%3A2%7D%22%2C%22channelId%22%3A%2219%3A560beeb3bd614067b1bfa4ee703d51a6%40thread.tacv2%22%7D&tenantId=9eda8bf9-6b95-4b12-98e4-1b12c2b27a27
     *
     *
     * @param Request $request
     */
    public static function setFilters_toSession(Request $request) {
        if (!$request->has('url-filters')) return;

        $filters_forSession = [];
        foreach ($request->input('url-filters') as $key => $filter) {
            if(!is_array($filter)){
                $filters_forSession[$key] = $filter;
                continue;
            }
            $value = $filter['value'] ?? null;
            if (array_key_exists('ajaxS2-modelType', $filter)) {
                $value = self::getSearchResultArr($filter['ajaxS2-modelType'], $value);
            }
            $filters_forSession[$key] = $value;
        }

        Session::flash('url-filters', $filters_forSession);
    }

    /**
     * Obtains search result arr for various models.
     *
     * @param $keyword
     * @param $value
     * @return null
     */
    public static function getSearchResultArr($keyword, $value) {
        $searchResultArr = null;
        switch ($keyword) {
            case 'user':
                $record = User::firstWhere('uuid', $value);
//                if(!is_null($record))   $searchResultArr = UserSearchController::getResultsArr_forGeneralUse($record);
                break;
            default:
                $searchResultArr = null;
        }
        return $searchResultArr;
    }

    /**
     * Returns Single Filter based URLs. This is to reduce code-lines in main-stream code.
     * @param $routeName
     * @param $filterInputId
     * @param $filterData
     * @param array $routeParams
     * @return string
     */
    public static function getSingleFilterUrl($routeName, $filterInputId, $filterData, $routeParams = []) {
        return route($routeName, array_merge([
            'url-filters' => [
                $filterInputId => $filterData
            ]
        ], $routeParams));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SideBarMenuController extends Controller
{
    protected $authUser;

    public function __construct() {
        $this->authUser = Auth::user();
    }

    public function getSidebar(){
        $sidebarArr = config('sidebar-menu');
        global $renderedHtml;

        foreach ($sidebarArr as $item) {
            $this->recursiveRenderingFunction($item);
        }
        return $renderedHtml;
    }

    public function recursiveRenderingFunction($sidebarItem){
        global $renderedHtml;
        if(! $this->validateItemPermission($sidebarItem))   return ;
        if(sizeof($sidebarItem['children']) > 0){
            $renderedHtml .= "<li class=\"nav-item has-treeview\">
                                    <a class=\"nav-link\" href=\"#\">"
                . $sidebarItem['name'] . "<i class=\"nav-icon fas fa-angle-left right\"></i></a>
                                <ul class=\"nav nav-treeview\">";

            foreach ($sidebarItem['children'] as $child) {
                $this->recursiveRenderingFunction($child);
            }
            $renderedHtml .= "</ul></li>";
        }else{
            if($sidebarItem['isHeader']){
                $renderedHtml .= "<li class=\"nav-header\">".$sidebarItem['name']."</li>";
            }else{
                $active = "";
                if(request()->url() === $this->getRouteAction($sidebarItem['route'])
                    || request()->is(str_replace(config('app.url') .'/', '', $this->getRouteAction($sidebarItem['route']) . '*'))) $active = "active";
                $renderedHtml .= "<li class=\"nav-item\"><a class=\"nav-link ". $active ."\" href='"
                    .$this->getRouteAction($sidebarItem['route'])
                    ."'>".$sidebarItem['name']
                    ."</a></li>";
            }
        }
    }

    protected function validateItemPermission($item) {
        if(array_key_exists('permissions', $item)){
            return self::validatePermissions($item['permissions']);
        }else {
            $routeObject = Route::getRoutes()->getByName($this->getRouteName($item['route']));
            $middlewares = $routeObject ? $routeObject->controllerMiddleware() : [];

            foreach ($middlewares as $middleware) {
                if (Str::is('permission:*', $middleware)) {
                    $permissions = explode('|', str_replace('permission:', '', $middleware));
                    return self::validatePermissions($permissions);
                }
            }
            return true;
        }
    }

    /**
     * @param $permissions
     * @return bool
     */
    protected function validatePermissions($permissions)
    {
        foreach ($permissions as $permission) {
            return $this->authUser->can($permission);
        }
        return false;
    }

    /**
     * Get the action for a "route" option.
     *
     * @param  array|string $options
     *
     * @return string
     */
    protected function getRouteAction($options)
    {
        if (is_array($options))     return route($options[0], array_slice($options, 1));
        if(empty($options))     return 'javascript:void(0);';

        return route($options);
    }

    /**
     * get only rout name
     * @param $options
     * @return mixed
     */
    protected function getRouteName($options)
    {
        if (is_array($options))     return $options[0];
        else return $options;
    }
}

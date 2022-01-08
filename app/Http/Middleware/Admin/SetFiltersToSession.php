<?php

namespace App\Http\Middleware\Admin;

use App\MyClasses\Filters;
use Closure;

class SetFiltersToSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Filters::setFilters_toSession($request);
        return $next($request);
    }
}

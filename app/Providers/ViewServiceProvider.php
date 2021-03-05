<?php

namespace App\Providers;
use App\Models\FaqCategory;

use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\User;
use App\Models\ArtCategory;
use App\Models\Artist;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['admin.users.fields'], function ($view) {
            $view->with('roleItems', Role::pluck('name', 'name')->toArray());
        });
    }
}

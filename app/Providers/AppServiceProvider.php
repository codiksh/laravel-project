<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use InfyOm\Generator\Generators\Scaffold\RequestGenerator;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $singletons = [
        RequestGenerator::class => \App\Overrides\CrudGenerator\Generators\Scaffold\RequestGenerator::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);   //For lower mysql versions
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}

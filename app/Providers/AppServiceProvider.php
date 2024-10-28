<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Codiksh\Generator\Common\GeneratorConfig;
use Codiksh\Generator\Generators\Scaffold\RequestGenerator;
use Codiksh\Generator\Generators\Scaffold\ViewGenerator;
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
        ViewGenerator::class => \App\Overrides\CrudGenerator\Generators\Scaffold\ViewGenerator::class,
        GeneratorConfig::class => \App\Overrides\CrudGenerator\Common\GeneratorConfig::class,
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

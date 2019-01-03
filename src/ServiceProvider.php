<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace StevenLei\LaravelKeyValue;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'kv');
        $this->loadRoutesFrom(__DIR__ . '/../routes/keyvalue.php');
        $this->publishes([__DIR__ . '/../resources/assets' => public_path('vendor/laravel-keyvalue')]);
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('keyvalue.php')]);
        $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang')]);
        $this->publishes([__DIR__ . '/../databases/migrations' => database_path('migrations')]);
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->app->singleton('keyvalue', KeyValue::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [KeyValue::class, 'keyvalue'];
    }
}

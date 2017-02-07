<?php

namespace JCWolf\Autoform;

use Illuminate\Support\ServiceProvider;

class AutoformServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton( 'autoform', function () {
            return new Autoform;
        } );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {

        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'autoform'
        );

        $this->loadViewsFrom( __DIR__ . '/views', 'Autoform' );
    }

}
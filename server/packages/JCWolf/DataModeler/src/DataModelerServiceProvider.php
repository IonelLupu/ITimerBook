<?php

namespace JCWolf\DataModeler;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DataModelerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom( __DIR__ . '/stubs', 'DataModeler' );

        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'modeler'
        );

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {

    }
}

;
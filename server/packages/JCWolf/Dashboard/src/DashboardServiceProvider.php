<?php

namespace JCWolf\Dashboard;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JCWolf\Autoform\AutoformFacade;
use Zizaco\Entrust\EntrustFacade;
use Zizaco\Entrust\EntrustServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {

        $this->mergeConfigFrom(
            __DIR__ . '/config/dashboard.php', 'dashboard'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/entrust.php', 'dashboard-entrust'
        );
        \Config::set( 'entrust', config( 'dashboard-entrust' ) );

        $this->setupRoutes( $this->app->router );

        $this->loadViewsFrom( __DIR__ . '/views', 'Dashboard' );

        $this->app->router->middleware( 'role', \Zizaco\Entrust\Middleware\EntrustRole::class );
        $this->app->router->middleware( 'permission', \Zizaco\Entrust\Middleware\EntrustPermission::class );
        $this->app->router->middleware( 'ability', \Zizaco\Entrust\Middleware\EntrustAbility::class );

        $this->publishes( [
            __DIR__ . '/public/dashboard' => public_path( 'dashboard' ),
        ], 'dashboard:public' );

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {

        /*
         * Register the service provider for the dependency.
         */
        $this->app->register( EntrustServiceProvider::class );
        $this->app->register( \Collective\Html\HtmlServiceProvider::class );

        /*
         * Create aliases for the dependency.
         */
        $loader = AliasLoader::getInstance();
        $loader->alias( 'Autoform', AutoformFacade::class );
        $loader->alias( 'Entrust', EntrustFacade::class );
        $loader->alias( 'Html', \Collective\Html\HtmlFacade::class );
        $loader->alias( 'Dashboard', Facade::class );

        $this->app->singleton( 'dashboard', function () {
            return new Dashboard;
        } );

    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes( Router $router ) {

        $router->group( [
            'namespace'  => __NAMESPACE__ . '\Http\Controllers',
            'prefix'     => 'admin',
            'middleware' => [ 'web' ]
        ], function () use ( $router ) {

            Route::auth();

            $router->group( [
                'middleware' => [ 'role:admin' ]
            ], function () {

                require __DIR__ . '/Http/routes.php';
            } );
        } );


    }


}
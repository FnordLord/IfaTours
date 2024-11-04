<?php

namespace Modules\IfaTours\Providers;

use App\Models\Airport;
use App\Models\Flight;
use App\Services\ModuleService;
use Illuminate\Support\ServiceProvider;
use Route;

class IfaToursServiceProvider extends ServiceProvider
{
    protected $moduleSvc;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->moduleSvc = app(ModuleService::class);

        $this->registerRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $this->registerLinks();

        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([
            __DIR__.'/../Resources/assets/tinymce' => public_path('vendor/ifatours/tinymce'),
        ], 'public');

        Flight::macro('dpt_airport', function() {
            return $this->belongsTo(Airport::class, 'dpt_airport_id');
        });

        Flight::macro('arr_airport', function() {
            return $this->belongsTo(Airport::class, 'arr_airport_id');
        });

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'ifatours');

        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('views/vendor/ifatours'),
        ], 'views');

    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Add module links here
     */
    public function registerLinks()
    {
        $this->moduleSvc->addAdminLink('IFA Tours', '/admin/ifatours');
        $this->moduleSvc->addFrontendLink('Tours & Charters', '/ifatours/tours', '', false);
    }

    /**
     * Register the routes
     */
    protected function registerRoutes()
    {
        /*
         * Routes for the frontend
         */
        Route::group([
            'as'     => 'ifatours.',
            'prefix' => 'ifatours',
            'middleware' => ['web'],
            'namespace'  => 'Modules\IfaTours\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/Routes/web.php');
        });

        /*
         * Routes for the admin
         */
        Route::group([
            'as'     => 'ifatours.',
            'prefix' => 'admin/ifatours',
            'middleware' => ['web', 'role:admin'],
            'namespace'  => 'Modules\IfaTours\Http\Controllers\Admin',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/Routes/admin.php');
        });

    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('ifatours.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'ifatours'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/IfaTours');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $paths = array_map(
            function ($path) {
                return $path.'/modules/IfaTours';
            },
            \Config::get('view.paths')
        );

        $paths[] = $sourcePath;
        $this->loadViewsFrom($paths, 'ifatours');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/IfaTours');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'ifatours');
        } else {
            $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'ifatours');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}

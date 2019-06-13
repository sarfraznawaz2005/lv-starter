<?php

namespace Modules\Core\Providers;

use Bepsvpt\SecureHeaders\SecureHeadersMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Cleanup;
use Modules\Core\Console\RouteList;
use Modules\Core\Console\VendorCleanup;
use Modules\Core\Http\Middleware\Cached;
use Modules\Core\Http\Middleware\EnvLogoMiddleware;
use Modules\Core\Http\Middleware\HttpsProtocol;
use Modules\Core\Http\Middleware\OptimizeMiddleware;
use Modules\Core\Http\Middleware\WeakEtagMiddleware;
use Modules\Core\Http\Middleware\XSSProtection;
use function config;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @param Router $router
     * @param Kernel $kernel
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        #################################################
        // register our custom middlewares
        #################################################

        // route middlewares
        $router->aliasMiddleware('XSSProtection', XSSProtection::class);
        $router->aliasMiddleware('cached', Cached::class);

        if (config('core.settings.minify_html_response')) {
            $kernel->pushMiddleware(OptimizeMiddleware::class);
        }

        if (config('core.settings.use_weak_etags')) {
            $kernel->pushMiddleware(WeakEtagMiddleware::class);
        }

        #################################################
        // register our commands
        #################################################
        $this->commands([
            Cleanup::class,
            VendorCleanup::class,
            RouteList::class,
        ]);

        #################################################
        // register our components
        #################################################
        Blade::component('core::components.card', 'card');
        Blade::component('core::components.modal', 'modal');
        Blade::component('core::components.button', 'button');

        #################################################

        #################################################
        // enable/disable stuff on live vs local/staging
        #################################################
        if (config('app.env') === 'production') {

            // turn on https mode
            $kernel->pushMiddleware(HttpsProtocol::class);

            // setup secure headers
            $kernel->pushMiddleware(SecureHeadersMiddleware::class);

            // disable query log
            queryLog(false);
        } else {
            //$kernel->pushMiddleware(EnvLogoMiddleware::class);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('core.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'core'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/core');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, \Config::get('view.paths')), [$sourcePath]), 'core');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'core');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

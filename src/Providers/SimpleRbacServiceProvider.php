<?php

namespace Zohaib482\SimpleRbac\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class SimpleRbacServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/simplerbac.php',
            'simplerbac'
        );
    }

    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'simplerbac');

        // Publish views - FIXED PATH
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/simple-rbac'),
        ], 'simple-rbac-views');

        // Publish config
        $this->publishes([
            __DIR__.'/../../config/simplerbac.php' => config_path('simplerbac.php'),
        ], 'simple-rbac-config');

        // Publish migrations (only in console)
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'simple-rbac-migrations');
        }

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Register middleware aliases - FIXED NAMESPACES
        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('role', \Zohaib482\SimpleRbac\Http\Middleware\CheckRole::class);
        $router->aliasMiddleware('permission', \Zohaib482\SimpleRbac\Http\Middleware\CheckPermission::class);
        $router->aliasMiddleware('verified.roles', \Zohaib482\SimpleRbac\Http\Middleware\RequireVerificationForRoles::class);
    }
}

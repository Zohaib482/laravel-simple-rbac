<?php

namespace Zohaib482\SimpleRbac\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->loadRoutesFrom(
            __DIR__.'/../../routes/web.php'
        );
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'simplerbac');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/simple-rbac'),
        ], 'simple-rbac-views');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'simplerbac-migrations');
        }

        // Auto-load migrations without publishing (optional, for quick setup)
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        /** @var \Illuminate\Routing\Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('role',       \Zohaib\SimpleRbac\Http\Middleware\CheckRole::class);
        $router->aliasMiddleware('permission', \Zohaib\SimpleRbac\Http\Middleware\CheckPermission::class);

        // If you created the optional verification + roles middleware too:
        $router->aliasMiddleware('verified.roles', \Zohaib\SimpleRbac\Http\Middleware\RequireVerificationForRoles::class);
    }
}

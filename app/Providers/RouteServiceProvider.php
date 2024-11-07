<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Http\Controllers';
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        // $this->routes(function ()
        // {
        //     Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
        //     Route::middleware('web')->group(base_path('routes/web.php'));
        // });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        $this->mapCustomApiRoutes();
        $this->mapCustomWebRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    protected function mapCustomApiRoutes()
    {
        Route::middleware(['api'])->namespace($this->namespace)->prefix('api/auth')->group(base_path('routes/api/auth.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/instituciones')->group(base_path('routes/api/instituciones.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/observaciones')->group(base_path('routes/api/observaciones.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/puestos')->group(base_path('routes/api/puestos.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/empleados')->group(base_path('routes/api/empleados.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/planilla')->group(base_path('routes/api/planilla.php'));
        Route::middleware('auth:api')->namespace($this->namespace)->prefix('api/reportes')->group(base_path('routes/api/reportes.php'));

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
            
    }

    protected function mapCustomWebRoutes()
    {

    }
}

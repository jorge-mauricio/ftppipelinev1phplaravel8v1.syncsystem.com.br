<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            //Route::prefix('api')
            Route::prefix(config('app.gSystemConfig.configRouteAPI'))
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });

        // Set global verifications.
        // Route::pattern('idTbCategories', '[+-]?([0-9]*[.])?[0-9]+'); // float number
        // Route::pattern('idTbCategories', '[a-zA-Z]'); // alphabet
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
    // TODO: test to check if needs to update with config('app.gSystemConfig.configRouteAPI')
}

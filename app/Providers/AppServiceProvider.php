<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
        Passport::routes(null, ['middleware' => [
            // You can make this simpler by creating a tenancy route group
            // InitializeTenancyByDomain::class,
            InitializeTenancyByPath::class,
            PreventAccessFromCentralDomains::class,
        ]]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Passport::loadKeysFrom(base_path(config('passport.key_path')));
        // Passport::routes();  
        //
    }
}

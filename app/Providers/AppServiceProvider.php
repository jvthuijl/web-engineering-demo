<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\OAuth2\Client\Provider\Github;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Github::class, function ($app) {
            return new Github([
                'clientId' => config('app.github_client_id'),
                'clientSecret' => config('app.github_client_secret'),
                'redirectUri' => url('/')
            ]);
        });
    }
}

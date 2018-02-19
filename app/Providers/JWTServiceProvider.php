<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\JWTHelper;

class JWTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //nothing to see here
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //bind singleton helper to this applciation via this service provider
        $this->app->bind('JWTHelper', function()
        {
            return new JWTHelper(config('auth')['JWT']['secret'],config('auth')['JWT']['expiry']);
        });
    }
}

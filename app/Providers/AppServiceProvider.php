<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Laravel\Socialite\Contracts\Factory;


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
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('doximity', function () use ($socialite) {
            $config = config('services.doximity');
    
            return $socialite->buildProvider(SocialiteDoximityProvider::class, $config);
        });

    }
}

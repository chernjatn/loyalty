<?php

namespace App\Providers;

use App\Enums\LoyaltyType;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->scoped(LoyaltyType::class, static function ($app) {
            $value = explode('/', $app['request']->path())[0];

            return LoyaltyType::from($value);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

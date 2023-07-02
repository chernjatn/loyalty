<?php

namespace App\Providers;

use App\Enums\LoyaltyType;
use App\Response\ApiResponse;
use App\Response\Response;
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

            return LoyaltyType::fromValue($value);
        });

        $this->app->bind(Response::class, ApiResponse::class);
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

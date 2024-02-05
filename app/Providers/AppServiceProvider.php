<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Response::macro('api', function ($data, $status = 200, $message = null) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $status);
        });
    }
}

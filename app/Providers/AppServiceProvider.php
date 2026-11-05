<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
    public function boot(): void
    {
        // Hanya paksa HTTPS jika mendeteksi proxy Ngrok atau jika berada di environment production
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || !app()->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
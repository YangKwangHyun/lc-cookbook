<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('layouts.app', function ($view) {
            $announcement = \App\Models\Announcement::first();

            $view->with([
                'bannerText'  => $announcement->bannerText,
                'bannerColor' => $announcement->bannerColor,
                'isActive'    => $announcement->isActive,
            ]);
        });

        Http::macro('movies', function () {
            return Http::withHeaders([
                'X-Example' => 'example',
            ])
                ->withToken(config('services.tmdb.bearerToken'))
                ->baseUrl('https://api.themoviedb.org/3');
        });
    }
}

<?php

namespace App\Providers;

use App\Http\Services\HashService;
use App\Http\Services\UrlService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        $this->app->singleton(HashService::class);
        $this->app->singleton(UrlService::class);

        $this->app->when(UrlService::class)
            ->needs('$shortUrlCharacters')
            ->give(config('services.url.short_url_characters'))
        ;

        $this->app->when(UrlService::class)
            ->needs('$shortUrlLength')
            ->give(config('services.url.short_url_length'))
        ;
    }
}

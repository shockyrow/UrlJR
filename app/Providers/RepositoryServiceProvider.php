<?php


namespace App\Providers;


use App\Http\Repositories\Url\EloquentUrl;
use App\Http\Repositories\Url\UrlRepository;
use App\Http\Services\UrlService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(UrlRepository::class, env('URL_REPOSITORY_CLASS', EloquentUrl::class));

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
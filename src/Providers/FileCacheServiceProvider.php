<?php

namespace AliRaza\FileCache\Providers;

use Illuminate\Support\ServiceProvider;
use AliRaza\FileCache\FileCache;
use Illuminate\Support\Facades\Cache;

class FileCacheServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/filecache.php', 'filecache'
        );

        $this->app->singleton('file.cache.store', function ($app) {
            $directory = config('filecache.cache_directory');
            return new FileCache($directory);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::extend('file_cache', function ($app) {
            $directory = config('filecache.cache_directory');
            return Cache::repository(new FileCache($directory));
        });
        
        $this->publishes([
            __DIR__.'/../config/filecache.php' => config_path('filecache.php'),
        ], 'config');
    }
}

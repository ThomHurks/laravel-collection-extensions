<?php

namespace ThomHurks\CollectionExtensions;

use Illuminate\Support\ServiceProvider;

class CollectionExtensionsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__.'/extensions.php';
    }
}

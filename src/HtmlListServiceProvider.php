<?php

namespace Exolnet\HtmlList;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class HtmlListServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('HtmlList', function () {
            return new HtmlList();
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Collection::macro('toHtmlList', function () {
            return HtmlList::make($this);
        });
    }
}

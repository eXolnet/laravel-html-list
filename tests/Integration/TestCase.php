<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Exolnet\HtmlList\HtmlListServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Html\Facades\Html;
use Spatie\Html\HtmlServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HtmlListServiceProvider::class,
            HtmlServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Html' => Html::class,
        ];
    }
}

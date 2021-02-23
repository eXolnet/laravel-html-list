<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlServiceProvider;
use Exolnet\HtmlList\HtmlListServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

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
            'form' => FormFacade::class,
            'Html' => HtmlFacade::class,
        ];
    }
}

<?php

namespace Exolnet\HtmlList\Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class UnitTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }
}

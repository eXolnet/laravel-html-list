<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Exolnet\HtmlList\HtmlList;
use Illuminate\Support\Collection;

class HtmlListTest extends TestCase
{
    public function testCollectionCanBeTransformedToHtmlList()
    {
        $collection = new Collection();

        $actual = $collection->toHtmlList();

        $this->assertInstanceOf(HtmlList::class, $actual);
    }
}

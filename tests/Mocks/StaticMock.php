<?php

namespace Exolnet\HtmlList\Tests\Mocks;

use Exolnet\HtmlList\Items\HtmlItem;
use Exolnet\HtmlList\Items\HtmlItemDefaults;

class StaticMock extends \stdClass implements HtmlItem
{
    use HtmlItemDefaults;
}

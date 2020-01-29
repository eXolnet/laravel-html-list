<?php

namespace Exolnet\HtmlList\Tests\Mocks;

use Exolnet\HtmlList\Items\HtmlItem;
use Exolnet\HtmlList\Items\HtmlItemDefaults;
use Illuminate\Database\Eloquent\Model;

class ModelMock extends Model implements HtmlItem
{
    use HtmlItemDefaults;
}

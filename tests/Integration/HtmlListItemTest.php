<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Exolnet\HtmlList\HtmlListItem;

class HtmlListItemTest extends TestCase
{
    public function testCheckbox()
    {
        $item = new HtmlListItem('Checkbox', 999);

        $checkbox = $item->checkbox('checkbox');

        $this->assertEquals('<input name="checkbox" type="checkbox" value="999">', $checkbox);
    }

    public function testRadio()
    {
        $item = new HtmlListItem('Radio', 999);

        $radio = $item->radio('radio');

        $this->assertEquals('<input name="radio" type="radio" value="999">', $radio);
    }
}

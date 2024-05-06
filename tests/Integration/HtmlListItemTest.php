<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Exolnet\HtmlList\HtmlListItem;

class HtmlListItemTest extends TestCase
{
    public function testCheckbox()
    {
        $item = new HtmlListItem('Checkbox', 999);

        $checkbox = $item->htmlCheckbox('checkbox')->toHtml();

        $this->assertEquals('<input type="checkbox" name="checkbox" id="checkbox" value="999">', $checkbox);
    }

    public function testRadio()
    {
        $item = new HtmlListItem('Radio', 999);

        $radio = $item->htmlRadio('radio')->toHtml();

        $this->assertEquals('<input type="radio" name="radio" id="radio_999" value="999">', $radio);
    }
}

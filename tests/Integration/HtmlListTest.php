<?php

namespace Exolnet\HtmlList\Tests\Integration;

use Exolnet\HtmlList\HtmlList;
use Exolnet\HtmlList\HtmlListItem;
use Exolnet\HtmlList\Tests\Mocks\ModelMock;
use Illuminate\Support\Collection;

class HtmlListTest extends TestCase
{
    public function testCollectionCanBeTransformedToHtmlList()
    {
        $collection = new Collection();

        $actual = $collection->toHtmlList();

        $this->assertInstanceOf(HtmlList::class, $actual);
    }

    /**
     * @return void
     */
    public function testHtmlListIsASingleton()
    {
        $htmlList1 = $this->app->make(HtmlList::class);
        $htmlList2 = $this->app->make(HtmlList::class);

        $this->assertEquals($htmlList1, $htmlList2);
    }

    public function testLabelEmpty()
    {
        $collection = new Collection();

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $htmlList->allowEmpty('Empty Label');
        $labelEmpty = $htmlList->getLabelEmpty();

        $this->assertEquals('Empty Label', $labelEmpty);
    }

    public function testBuild()
    {
        $item = new ModelMock();
        $item->setKeyName('foo');
        $item->foo = 1;
        $item->label = 'foo';

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $buildedHtmlList = $htmlList->build();

        $this->assertCount(1, $buildedHtmlList->toArray());

        /** @var HtmlListItem $firstElement */
        $firstElement = $buildedHtmlList->get(0);

        $this->assertInstanceOf(HtmlListItem::class, $firstElement);

        $this->assertEquals('foo', $firstElement->getKey());
        $this->assertEquals('label', $firstElement->getLabel());

        $this->assertEquals(1, $firstElement->getHtmlItem()->{$firstElement->getKey()});
        $this->assertEquals('foo', $firstElement->getHtmlItem()->{$firstElement->getLabel()});
    }

    public function testBuildEmptyLabel()
    {
        $item = new ModelMock();
        $item->setKeyName('foo');
        $item->foo = 1;
        $item->label = 'foo';

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();
        $htmlList->allowEmpty('Empty Label');

        $buildedHtmlList = $htmlList->build();

        $this->assertCount(2, $buildedHtmlList->toArray());

        /** @var HtmlListItem $firstElement */
        $firstElement = $buildedHtmlList->get(0);

        $this->assertInstanceOf(HtmlListItem::class, $firstElement);

        $this->assertEquals('id', $firstElement->getKey());
        $this->assertEquals('label', $firstElement->getLabel());

        $this->assertEquals(null, $firstElement->getHtmlItem()['id']);
        $this->assertEquals('Empty Label', $firstElement->getHtmlItem()['label']);
    }

    public function testBuildArray()
    {
        $item = new ModelMock();
        $item->id = 1;
        $item->label = 'bar';

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $buildArrayHtmlList = $htmlList->buildArray();

        $this->assertEquals([1 => 'bar'], $buildArrayHtmlList);
    }

    public function testHtmlListCallbacks()
    {
        $item = new ModelMock();
        $item->key = 1;
        $item->bar = 'label';

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $htmlList->valued(function () {
            return 'key';
        });

        $htmlList->labelled(function () {
            return 'bar';
        });

        $buildArrayHtmlList = $htmlList->buildArray();

        $this->assertEquals([1 => 'label'], $buildArrayHtmlList);
    }

    public function testSelect()
    {
        $item = new ModelMock();
        $item->label = 'AAAAA';
        $item->id = 9999;

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $select = $htmlList->select('select')->toHtml();

        $this->assertEquals('<select name="select" id="select"><option value="9999">AAAAA</option></select>', $select);
    }

    public function testSelectWithEmptyLabel()
    {
        $item = new ModelMock();
        $item->label = 'Second element label';
        $item->id = 9999;

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();
        $htmlList->allowEmpty('Empty Label');

        $select = $htmlList->select('select')->toHtml();

        $this->assertEquals(
            '<select name="select" id="select"><option value>Empty Label</option><option value="9999">Second element label</option></select>', // phpcs:ignore
            $select
        );
    }
}

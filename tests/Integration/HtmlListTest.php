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

        $this->assertEquals(1, $firstElement->getKey());
        $this->assertEquals('foo', $firstElement->getLabel());
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
        $this->assertEquals('Default label', $firstElement->getLabel());

        $this->assertEquals(null, $firstElement->getHtmlItem()['id']);
        $this->assertEquals('Empty Label', $firstElement->getHtmlItem()['Default label']);
    }

    public function testBuildArray()
    {
        $item = new ModelMock();
        $item->id = 'key';
        $item->label = 'bar';

        $item->key = 1;
        $item->bar = 'label';

        $collection = new Collection([
            $item,
        ]);

        /** @var HtmlList $actual */
        $htmlList = $collection->toHtmlList();

        $buildArrayHtmlList = $htmlList->buildArray();

        $this->assertEquals([1 => 'label'], $buildArrayHtmlList);
    }

    public function testHtmlListCallbacks()
    {
        $item = new ModelMock();
        $item->id = 'test';
        $item->label = 'testbar';

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
}

<?php

namespace Exolnet\HtmlList\Tests\Unit;

use Exolnet\HtmlList\Tests\Mocks\ModelMock;
use Exolnet\HtmlList\Tests\Mocks\StaticMock;

class HtmlItemTest extends UnitTest
{
    /**
     * @return void
     */
    public function testGetHtmlItemKeyNameDefault(): void
    {
        $item = new StaticMock();

        $this->assertEquals('id', $item->getHtmlItemKeyName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemKeyNameDefined(): void
    {
        $item = new StaticMock();

        $item->htmlItemKey = 'foo';

        $this->assertEquals('foo', $item->getHtmlItemKeyName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemKeyNameModelUseKeyNameByDefault(): void
    {
        $item = new ModelMock();
        $item->setKeyName('foo');

        $this->assertEquals('foo', $item->getHtmlItemKeyName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemKey(): void
    {
        $item = new StaticMock();

        $item->htmlItemKey = 'foo';
        $item->foo = 'bar';

        $this->assertEquals('bar', $item->getHtmlItemKey());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemKeyNameModelDefined(): void
    {
        $item = new ModelMock();
        $item->setKeyName('foo');

        $item->htmlItemKey = 'bar';

        $this->assertEquals('bar', $item->getHtmlItemKeyName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemLabelNameDefault(): void
    {
        $item = new StaticMock();

        $this->assertEquals('label', $item->getHtmlItemLabelName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemLabelNameDefined(): void
    {
        $item = new StaticMock();

        $item->htmlItemLabel = 'foo';

        $this->assertEquals('foo', $item->getHtmlItemLabelName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemLabelNameModelUseKeyNameByDefault(): void
    {
        $item = new ModelMock();

        $this->assertEquals('label', $item->getHtmlItemLabelName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemLabelNameModelDefined(): void
    {
        $item = new ModelMock();

        $item->htmlItemLabel = 'foo';

        $this->assertEquals('foo', $item->getHtmlItemLabelName());
    }

    /**
     * @return void
     */
    public function testGetHtmlItemLabel(): void
    {
        $item = new StaticMock();

        $item->htmlItemLabel = 'foo';
        $item->foo = 'bar';

        $this->assertEquals('bar', $item->getHtmlItemLabel());
    }
}

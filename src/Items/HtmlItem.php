<?php

namespace Exolnet\HtmlList\Items;

interface HtmlItem
{
    /**
     * @return string|int
     */
    public function getHtmlItemKey();

    /**
     * @return string
     */
    public function getHtmlItemLabel(): string;
}

<?php

namespace Exolnet\HtmlList\Items;

trait HtmlItemDefaults
{
    /**
     * @return string
     */
    public function getHtmlItemKeyName(): string
    {
        if (isset($this->htmlItemKey)) {
            return $this->htmlItemKey;
        }

        if (method_exists($this, 'getKeyName')) {
            return $this->getKeyName();
        }

        return 'id';
    }

    /**
     * @return mixed
     */
    public function getHtmlItemKey()
    {
        return $this->getHtmlItemKeyName();
    }

    /**
     * @return string
     */
    public function getHtmlItemLabelName(): string
    {
        return $this->htmlItemLabel ?? 'label';
    }

    /**
     * @return string
     */
    public function getHtmlItemLabel(): string
    {
        return $this->getHtmlItemLabelName();
    }
}

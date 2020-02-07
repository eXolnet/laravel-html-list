<?php

namespace Exolnet\HtmlList;

use Collective\Html\FormFacade;
use Exolnet\HtmlList\Items\HtmlItem;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class HtmlList extends Collection
{
    /**
     * @var string|null
     */
    protected $labelEmpty = null;

    /**
     * @var callable|null
     */
    protected $callbackKey;

    /**
     * @var callable|null
     */
    protected $callbackLabel;

    /**
     * @var string|null
     */
    protected $model = null;

    /**
     * @return string|null
     */
    public function getLabelEmpty(): ?string
    {
        return $this->labelEmpty;
    }

    /**
     * @param string|null $labelEmpty
     * @return $this
     */
    public function allowEmpty(?string $labelEmpty = ''): self
    {
        $this->labelEmpty = $labelEmpty;

        return $this;
    }

    /**
     * @return callable
     */
    public function getCallbackKey(): callable
    {
        if ($this->callbackKey) {
            return $this->callbackKey;
        }

        return function (HtmlItem $htmlItem) {
            return $htmlItem->getHtmlItemKey();
        };
    }

    /**
     * @param callable|null $callbackKey
     * @return $this
     */
    public function valued(?callable $callbackKey): self
    {
        $this->callbackKey = $callbackKey;

        return $this;
    }

    /**
     * @return callable
     */
    public function getCallbackLabel(): callable
    {
        if ($this->callbackLabel) {
            return $this->callbackLabel;
        }

        return function (HtmlItem $htmlItem) {
            return $htmlItem->getHtmlItemLabel();
        };
    }

    /**
     * @param callable|null $callbackLabel
     * @return $this
     */
    public function labelled(?callable $callbackLabel): self
    {
        $this->callbackLabel = $callbackLabel;

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function build(): Collection
    {
        return $this
            ->map(function (HtmlItem $htmlItem) {
                if(!$this->model) {
                    $this->model = get_class($htmlItem);
                }

                $htmlListItem = new HtmlListItem(
                    $this->getCallbackLabel()->__invoke($htmlItem),
                    $this->getCallbackKey()->__invoke($htmlItem)
                );

                $htmlListItem->setHtmlItem($htmlItem);

                return $htmlListItem;
            })
            ->when($this->getLabelEmpty() !== null && $this->model, function (HtmlList $htmlList) {
                $emptyHtmlItem = new $this->model();

                $label = $this->getCallbackLabel()->__invoke($emptyHtmlItem);
                $key = $this->getCallbackKey()->__invoke($emptyHtmlItem);

                $emptyHtmlItem->setAttribute($label, $this->getLabelEmpty())
                    ->setAttribute($key, null);

                $emptyhtmlListItem = new HtmlListItem(
                    $label,
                    $key
                );

                $emptyhtmlListItem->setHtmlItem($emptyHtmlItem);

                return $htmlList->prepend($emptyhtmlListItem);
            })
            ->toBase();
    }

    /**
     * @return array
     */
    public function buildArray(): array
    {
        return $this
            ->build()
            ->mapWithKeys(function (HtmlListItem $htmlListItem) {
                $key = $htmlListItem->getKey();
                $label = $htmlListItem->getLabel();
                $item = $htmlListItem->getHtmlItem();

                return [$item->getAttribute($key) => $item->getAttribute($label)];
            })
            ->all();
    }

    /**
     * @param string $name
     * @param mixed $selected
     * @param array $selectAttributes
     * @param array $optionsAttributes
     * @param array $optgroupsAttributes
     * @return \Illuminate\Support\HtmlString
     */
    public function select(
        string $name,
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ): HtmlString {
        return FormFacade::select(
            $name,
            $this->buildArray(),
            $selected,
            $selectAttributes,
            $optionsAttributes,
            $optgroupsAttributes
        );
    }
}

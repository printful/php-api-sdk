<?php


namespace Printful\Structures\Generator;


use Printful\Structures\BaseItem;

class MockupExtraItem extends BaseItem
{
    /**
     * Title of the extra mockup, like "Wrinkled front", for mugs "Handle from left", etc.
     * These values can change over time, do not hard-code / rely on them.
     *
     * @var string
     */
    public $title;

    /**
     * URL where mockup can be downloaded from
     *
     * @var string
     */
    public $url;

    /**
     * @param array|string $raw
     * @return MockupExtraItem
     */
    public static function fromArray(array $raw)
    {
        $item = new MockupExtraItem;

        $item->title = $raw['title'];
        $item->url = $raw['url'];

        return $item;
    }
}
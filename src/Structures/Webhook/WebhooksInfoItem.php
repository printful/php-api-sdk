<?php

namespace Printful\Structures\Webhook;

class WebhooksInfoItem
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $types = [];

    /**
     * @var array
     */
    public $params = [];

    /**
     * @param array $raw
     * @return WebhooksInfoItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->url = $raw['url'];
        $item->types = $raw['types'];
        $item->params = $raw['params'];

        return $item;
    }
}

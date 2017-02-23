<?php
namespace Printful\Structures\Webhook;

use Printful\Structures\BaseItem;

class WebhookItem extends BaseItem
{
    /** Is called when a shipment with all or part of the ordered items is shipped */
    const TYPE_PACKAGE_SHIPPED = 'package_shipped';
    /** Is called when a confirmed order changes its status to failed */
    const TYPE_ORDER_FAILED = 'order_failed';
    /** Is called when a confirmed order changes its status to canceled */
    const TYPE_ORDER_CANCELED = 'order_canceled';
    /** Is called when a new product or variant is imported from store's e-commerce integration. */
    const TYPE_PRODUCT_SYNCED = 'product_synced';
    /** Is called when stock is updated for some of product's variants. */
    const TYPE_STOCK_UPDATED = 'stock_updated';

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $created;

    /**
     * @var int
     */
    public $retries;

    /**
     * @var int
     */
    public $store;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @param array $raw
     * @return WebhookItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->type = $raw['type'];
        $item->created = $raw['created'];
        $item->retries = $raw['retries'];
        $item->store = $raw['store'];
        $item->data = $raw['data'];

        return $item;
    }
}

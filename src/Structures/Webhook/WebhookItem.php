<?php

namespace Printful\Structures\Webhook;

use Printful\Structures\BaseItem;
use Printful\Structures\Order\Order;
use Printful\Structures\Shipment\Shipment;

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
    /** Is called when order is put on hold. */
    const TYPE_ORDER_PUT_HOLD = 'order_put_hold';
    /** Is called when order is removed from hold. */
    const TYPE_ORDER_REMOVE_HOLD = 'order_remove_hold';
    /** Is called when a shipment is processed as returned to the fulfillment facility. */
    const TYPE_PACKAGE_RETURNED = 'package_returned';

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
    public $rawData;

    /**
     * @var string|null - Reason why webhook was triggered. Present for some webhooks
     */
    public $reason;

    /**
     * @var Order|null - Present only for webhooks that contain order data
     */
    public $order;

    /**
     * @var Shipment|null - Present only for webhooks that contain shipment data
     */
    public $shipment;

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
        $item->rawData = $raw['data'];

        if (isset($raw['data']['order'])) {
            $item->order = Order::fromArray($raw['data']['order']);
        }

        if (isset($raw['data']['shipment'])) {
            $item->shipment = Shipment::fromArray($raw['data']['shipment']);
        }

        if (isset($raw['data']['reason'])) {
            $item->reason = $raw['data']['reason'];
        }

        return $item;
    }
}

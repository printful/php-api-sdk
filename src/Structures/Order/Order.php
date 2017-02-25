<?php

namespace Printful\Structures\Order;

use Printful\Structures\AddressItem;
use Printful\Structures\BaseItem;
use Printful\Structures\Shipment\Shipment;

class Order extends BaseItem
{
    /** Order is not submitted for fulfillment */
    const STATUS_DRAFT = 'draft';

    /** Order was submitted for fulfillment but was not accepted because of an error (problem with address, printfiles, charging, etc.) */
    const STATUS_FAILED = 'failed';

    /** Order has been submitted for fulfillment */
    const STATUS_PENDING = 'pending';

    /** Order is canceled */
    const STATUS_CANCELED = 'canceled';

    /** Order has encountered a problem during the fulfillment that needs to be resolved together with the Printful customer service */
    const STATUS_ON_HOLD = 'onhold';

    /** Order is being fulfilled and is no longer cancellable */
    const STATUS_IN_PROCESS = 'inprocess';

    /** Order is partially fulfilled (some items are shipped already, the rest will follow) */
    const STATUS_PARTIAL = 'partial';

    /** All items are shipped */
    const STATUS_FULFILLED = 'fulfilled';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string - Order ID from the external system
     */
    public $externalId;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string - Shipping method
     */
    public $shipping;

    /**
     * @var int - Timestamp
     */
    public $created;

    /**
     * @var int - Timestamp
     */
    public $updated;

    /**
     * @var AddressItem
     */
    public $recipient;

    /**
     * @var OrderLineItem[]
     */
    public $items = [];

    /**
     * @var OrderCostsItem
     */
    public $costs;

    /**
     * @var OrderCostsItem
     */
    public $retailCosts;

    /**
     * @var Shipment[]
     */
    public $shipments = [];

    /**
     * @var GiftItem
     */
    public $gift;

    /**
     * @var PackingSlipItem
     */
    public $packingSlip;

    /**
     * @var string
     * 3 letter currency code (optional), required if the retail costs should be convert from another currency instead of USD
     */
    public $currency = 'USD';

    /**
     * @param array $raw
     * @return Order
     */
    public static function fromArray(array $raw)
    {
        $order = new self;
        $order->id = (int)$raw['id'];
        $order->externalId = $raw['external_id'];
        $order->status = $raw['status'];
        $order->shipping = $raw['shipping'];
        $order->created = (int)$raw['created'];
        $order->updated = (int)$raw['updated'];
        $order->recipient = AddressItem::fromArray($raw['recipient']);
        $order->costs = OrderCostsItem::fromArray($raw['costs']);
        $order->retailCosts = OrderCostsItem::fromArray($raw['retail_costs']);
        $order->gift = isset($raw['gift']) ? GiftItem::fromArray($raw['gift']) : null;
        $order->packingSlip = isset($raw['packing_slip']) ? PackingSlipItem::fromArray($raw['packing_slip']) : null;

        foreach ($raw['items'] as $v) {
            $order->items[] = OrderLineItem::fromArray($v);
        }

        foreach ($raw['shipments'] as $v) {
            $order->shipments[] = Shipment::fromArray($v);
        }

        return $order;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $items = [];
        foreach ($this->items as $v) {
            $items[] = $v->toArray();
        }

        return [
            'id' => (int)$this->id,
            'externalId' => $this->externalId,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'recipient' => $this->recipient->toArray(),
            'items' => $items,
            'retailPrice' => $this->retailCosts->toArray(),
            'gift' => $this->gift ? $this->gift->toArray() : null,
            'packingSlip' => $this->packingSlip ? $this->packingSlip->toArray() : null,
            'currency' => $this->currency,
        ];
    }
}
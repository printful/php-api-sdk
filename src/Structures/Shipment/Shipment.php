<?php

namespace Printful\Structures\Shipment;

use Printful\Structures\BaseItem;

class Shipment extends BaseItem
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $carrier;

    /**
     * @var string
     */
    public $service;

    /**
     * @var string
     */
    public $trackingNumber;

    /**
     * @var string
     */
    public $trackingUrl;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $shipDate;

    /**
     * @var bool
     */
    public $reshipment;

    /**
     * @var ShipmentItem[]
     */
    public $items;

    /**
     * @param array $raw
     * @return Shipment
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->id = (int)$raw['id'];
        $item->carrier = $raw['carrier'];
        $item->service = $raw['service'];
        $item->trackingNumber = $raw['tracking_number'];
        $item->trackingUrl = $raw['tracking_url'];
        $item->created = $raw['created'];
        $item->shipDate = $raw['ship_date'];
        $item->reshipment = (bool)$raw['reshipment'];

        // Shipment Items
        foreach ($raw['items'] as $v) {
            $item->items[] = ShipmentItem::fromArray($v);
        }

        return $item;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $re = [
            'id' => $this->id,
            'carrier' => $this->carrier,
            'service' => $this->service,
            'trackingNumber' => $this->trackingNumber,
            'trackingUrl' => $this->trackingUrl,
            'created' => $this->created,
            'shipDate' => $this->shipDate,
            'reshipment' => $this->reshipment,
        ];

        foreach ($this->items as $v) {
            $re['items'][] = $v->toArray();
        }

        return $re;
    }
}
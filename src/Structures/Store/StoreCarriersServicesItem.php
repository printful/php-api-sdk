<?php

namespace Printful\Structures\Store;

use Printful\Structures\BaseItem;

class StoreCarriersServicesItem extends BaseItem
{
    /**
     * ID of the carrier
     * @var
     */
    public $carrierId;

    /**
     * Carrier title
     * @var
     */
    public $title;

    /**
     * Carrier subtitle
     * @var
     */
    public $subtitle;

    /**
     * Carrier status - on/off
     * @var
     */
    public $status;

    /**
     * Carrier type - standard/expedited
     * @var
     */
    public $type;

    public static function fromArray(array $raw)
    {
        $carrier = new self;
        $carrier->carrierId = $raw['carrier_id'];
        $carrier->title = $raw['title'];
        $carrier->subtitle = $raw['subtitle'];
        $carrier->status = $raw['status'];
        $carrier->type = $raw['type'];

        return $carrier;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'carrier_id' => $this->carrierId,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
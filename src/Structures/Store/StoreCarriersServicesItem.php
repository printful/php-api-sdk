<?php

namespace Printful\Structures\Store;

use Printful\Structures\BaseItem;

class StoreCarriersServicesItem extends BaseItem
{
    public $id;

    public $title;

    public $subtitle;

    public $status;

    public $type;

    public static function fromArray(array $raw)
    {
        $carrier = new self;
        $carrier->id = $raw['id'];
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
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
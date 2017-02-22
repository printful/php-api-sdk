<?php

namespace Printful\Structures\Shipment;

use Printful\Structures\BaseItem;

class ShipmentItem extends BaseItem
{
    /**
     * @var int - Line item ID
     */
    public $itemId;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @param array $raw
     * @return ShipmentItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->itemId = (int)$raw['item_id'];
        $item->quantity = (int)$raw['quantity'];

        return $item;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'itemId' => $this->itemId,
            'quantity' => $this->quantity,
        ];
    }
}

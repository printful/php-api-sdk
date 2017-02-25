<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class OrderCostsItem extends BaseItem
{

    /**
     * @var string
     * Total cost of all items
     */
    public $subtotal;

    /**
     * @var string
     * Discount sum
     */
    public $discount;

    /**
     * @var string
     *  Shipping costs
     */
    public $shipping;

    /**
     * @var string
     * Sum of taxes (not included in the item price)
     */
    public $tax;

    /**
     * @var string
     * Sum of taxes (not included in the item price)
     */
    public $total;

    /**
     * @param array $raw
     * @return OrderCostsItem
     */
    public static function fromArray(array $raw)
    {
        $costs = new self;

        $costs->subtotal = $raw['subtotal'] ? (float)$raw['subtotal'] : null;
        $costs->discount = $raw['discount'] ? (float)$raw['discount'] : null;
        $costs->shipping = $raw['shipping'] ? (float)$raw['shipping'] : null;
        $costs->tax = $raw['tax'] ? (float)$raw['tax'] : null;
        $costs->total = $raw['total'] ? (float)$raw['total'] : null;

        return $costs;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'discount' => $this->discount,
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ];
    }
}

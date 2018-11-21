<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class OrderCostsItem extends BaseItem
{

    /**
     * @var float
     * Total cost of all items
     */
    public $subtotal;

    /**
     * @var float
     * Discount sum
     */
    public $discount;

    /**
     * @var float
     *  Shipping costs
     */
    public $shipping;

    /**
     * @var float
     * Sum of taxes (not included in the item price)
     */
    public $tax;

    /**
     * @var float
     * Sum of taxes (not included in the item price)
     */
    public $total;

    /**
     * @var string
     * 3 letter currency code
     */
    public $currency;

    /**
     * @var float
     * Digitization costs
     */
    public $digitization;

    /**
     * @var float
     * Sum of vat (not included in the item price)
     */
    public $vat;

    /**
     * @param array $raw
     * @return OrderCostsItem
     */
    public static function fromArray(array $raw)
    {
        $costs = new self;

        $costs->subtotal = isset($raw['subtotal']) ? (float)$raw['subtotal'] : null;
        $costs->discount = isset($raw['discount']) ? (float)$raw['discount'] : null;
        $costs->shipping = isset($raw['shipping']) ? (float)$raw['shipping'] : null;
        $costs->tax = isset($raw['tax']) ? (float)$raw['tax'] : null;
        $costs->total = isset($raw['total']) ? (float)$raw['total'] : null;
        $costs->currency = isset($raw['currency']) ? $raw['currency'] : null;
        $costs->digitization = isset($raw['digitization']) ? (float)$raw['digitization'] : null;
        $costs->vat = isset($raw['vat']) ? (float)$raw['vat'] : null;

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
            'currency' => $this->currency,
            'digitization' => $this->digitization,
            'vat' => $this->vat,
        ];
    }
}

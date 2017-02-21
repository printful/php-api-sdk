<?php

namespace Printful\Structures;

class StateItem extends BaseItem
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool - In some states shipping price is also included in tax calculation
     */
    public $isShippingTaxable;

    /**
     * @param array $raw
     * @return StateItem
     */
    public static function fromArray(array $raw)
    {
        $item = new StateItem;

        $item->code = $raw['code'];
        $item->name = $raw['name'];
        $item->isShippingTaxable = (bool)$raw['shipping_taxable'];

        return $item;
    }
}

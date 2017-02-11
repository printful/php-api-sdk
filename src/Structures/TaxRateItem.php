<?php

namespace Printful\Structures;

class TaxRateItem extends BaseItem
{
    /**
     * @var boolean
     */
    public $required;

    /**
     * @var float
     */
    public $rate;

    /**
     * @var bool - In some states shipping price is also included in tax calculation
     */
    public $isShippingTaxable;

    /**
     * @param array $raw
     * @return TaxRateItem
     */
    public static function fromArray(array $raw)
    {
        $item = new TaxRateItem;

        $item->rate = (float)$raw['rate'];
        $item->required = (bool)$raw['required'];
        $item->isShippingTaxable = (bool)$raw['shipping_taxable'];

        return $item;
    }
}

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
     * @param array $raw
     * @return TaxRateItem
     */
    public static function fromArray(array $raw)
    {
        $item = new TaxRateItem;

        $item->rate = (float)$raw['rate'];
        $item->required = (bool)$raw['required'];

        return $item;
    }
}

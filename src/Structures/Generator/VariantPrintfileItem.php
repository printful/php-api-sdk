<?php


namespace Printful\Structures\Generator;


use Printful\Structures\BaseItem;

class VariantPrintfileItem extends BaseItem
{
    /**
     * @var int
     */
    public $variantId;

    /**
     * Key is placement id, value is printfile id
     *
     * @var array [placement => printfileId]
     */
    public $placements = [];

    /**
     * Convert from raw response to item
     *
     * @param array $raw
     * @return VariantPrintfileItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->variantId = (int)$raw['variant_id'];
        $item->placements = $raw['placements'];

        return $item;
    }
}
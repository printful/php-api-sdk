<?php

namespace Printful\Structures\Sync;

class SyncVariantProduct
{
    /** @var int */
    public $variantId;

    /** @var int */
    public $productId;

    /** @var string */
    public $image;

    /** @var string */
    public $name;

    /**
     * Creates SyncVariantProduct from array in response
     *
     * @param array $array
     * @return SyncVariantProduct
     */
    public static function fromArray(array $array)
    {
        $syncVariantProduct = new SyncVariantProduct;

        $syncVariantProduct->variantId = (int)$array['variant_id'] ?: null;
        $syncVariantProduct->productId = (int)$array['product_id'] ?: null;
        $syncVariantProduct->image = (string)$array['image'] ?: '';
        $syncVariantProduct->name = (string)$array['name'] ?: '';

        return $syncVariantProduct;
    }
}
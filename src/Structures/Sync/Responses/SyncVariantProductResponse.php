<?php

namespace Printful\Structures\Sync\Responses;

class SyncVariantProductResponse
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
     * Creates SyncVariantProductResponse from array in response
     *
     * @param array $array
     * @return SyncVariantProductResponse
     */
    public static function fromArray(array $array)
    {
        $syncVariantProduct = new SyncVariantProductResponse;

        $syncVariantProduct->variantId = (int)$array['variant_id'] ?: null;
        $syncVariantProduct->productId = (int)$array['product_id'] ?: null;
        $syncVariantProduct->image = (string)$array['image'] ?: '';
        $syncVariantProduct->name = (string)$array['name'] ?: '';

        return $syncVariantProduct;
    }
}
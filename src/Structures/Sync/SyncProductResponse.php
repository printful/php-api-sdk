<?php

namespace Printful\Structures\Sync;

class SyncProductResponse
{
    /** @var SyncProduct */
    public $syncProduct;

    /** @var SyncVariant[] */
    public $syncVariants = [];

    /**
     * Creates SyncProductResponse from array
     *
     * @param array $array
     * @return SyncProductResponse
     */
    public static function fromArray(array $array)
    {
        $response = new SyncProductResponse;

        $productArray = $array['sync_product'];
        $response->syncProduct = SyncProduct::fromArray($productArray);

        $variantArray = $array['sync_variants'];
        foreach ($variantArray as $item){
            $response->syncVariants[] = SyncVariant::fromArray($item);
        }

        return $response;
    }
}
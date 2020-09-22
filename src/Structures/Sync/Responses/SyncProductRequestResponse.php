<?php

namespace Printful\Structures\Sync\Responses;

class SyncProductRequestResponse
{
    /** @var SyncProductResponse */
    public $syncProduct;

    /** @var SyncVariantResponse[] */
    public $syncVariants = [];

    /**
     * Creates SyncProductResponse from array
     *
     * @param array $array
     * @return SyncProductRequestResponse
     */
    public static function fromArray(array $array)
    {
        $response = new SyncProductRequestResponse;

        $productArray = $array['sync_product'];
        $response->syncProduct = SyncProductResponse::fromArray($productArray);

        $variantArray = $array['sync_variants'];
        foreach ($variantArray as $item) {
            $response->syncVariants[] = SyncVariantResponse::fromArray($item);
        }

        return $response;
    }
}
<?php

namespace Printful\Structures\Sync;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

class SyncProductCreationParameters
{
    /** @var SyncProductRequest */
    private $syncProduct;

    /** @var SyncVariantRequest[] */
    private $syncVariants = [];

    /**
     * SyncProductCreationParameters constructor.
     *
     * @param SyncProductRequest $syncProduct
     */
    public function __construct(SyncProductRequest $syncProduct)
    {
        $this->syncProduct = $syncProduct;
    }

    /**
     * Adds PostSyncVariant to PostSyncRequest
     *
     * @param SyncVariantRequest $syncVariant
     */
    public function addSyncVariant(SyncVariantRequest $syncVariant)
    {
        $this->syncVariants[] = $syncVariant;
    }

    /**
     * Returns PostSyncVariants added to SyncProductCreationParameters
     *
     * @return SyncVariantRequest[]
     */
    public function getVariants()
    {
        return $this->syncVariants;
    }

    /**
     * Returns SyncProductRequest
     *
     * @return SyncProductRequest
     */
    public function getProduct()
    {
        return $this->syncProduct;
    }

    /**
     * Builds SyncProductCreationParameters from array
     *
     * @param array $array
     * @return SyncProductCreationParameters
     */
    public static function fromArray(array $array)
    {
        $syncProductData = isset($array['sync_product']) ? (array)$array['sync_product'] : [];
        $syncProductRequest = SyncProductRequest::fromArray($syncProductData);

        $params = new SyncProductCreationParameters($syncProductRequest);

        $syncVariantData = isset($array['sync_variants']) ? (array)$array['sync_variants'] : [];
        foreach ($syncVariantData as $item) {
            $syncVariantRequest = SyncVariantRequest::fromArray($item);
            $params->addSyncVariant($syncVariantRequest);
        }

        return $params;
    }
}

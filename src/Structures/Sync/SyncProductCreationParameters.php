<?php

namespace Printful\Structures\Sync;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

class SyncProductCreationParameters extends SyncProductParameters
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
}

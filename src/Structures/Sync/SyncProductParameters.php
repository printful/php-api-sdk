<?php

namespace Printful\Structures\Sync;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

abstract class SyncProductParameters
{
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
<?php

namespace Printful\Structures\Sync;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

class SyncProductUpdateParameters
{
    /** @var SyncProductRequest|null */
    public $syncProduct;

    /** @var SyncVariantRequest[]|null */
    public $syncVariants;

    /**
     * Builds SyncProductUpdateParameters from array
     *
     * @param array $array
     * @return SyncProductUpdateParameters
     */
    public static function fromArray(array $array)
    {
        $params = new SyncProductUpdateParameters;

        if (isset($array['sync_product'])) {
            $params->syncProduct = SyncProductRequest::fromArray($array['sync_product']);
        }

        if (isset($array['sync_variants'])) {
            foreach ($array['sync_variants'] as $item) {
                $syncVariantRequest = SyncVariantRequest::fromArray($item);
                $params->syncVariants[] = $syncVariantRequest;
            }
        }

        return $params;
    }
}

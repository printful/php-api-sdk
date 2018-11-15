<?php

namespace Printful\Structures\Sync;

use Printful\Exceptions\PrintfulSdkException;
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

    /**
     * Builds PUT param array
     *
     * @return array
     * @throws PrintfulSdkException
     */
    public function toPutArray()
    {
        $params = [];

        $requestSyncProduct = $this->syncProduct;
        $requestSyncVariants = $this->syncVariants;

        if (!$requestSyncProduct && !$requestSyncVariants) {
            throw new PrintfulSdkException('Nothing to update');
        }

        if ($requestSyncProduct) {
            $syncProduct = [];

            if ($requestSyncProduct->name) {
                $syncProduct['name'] = $requestSyncProduct->name;
            }

            if ($requestSyncProduct->thumbnail) {
                $syncProduct['thumbnail'] = $requestSyncProduct->thumbnail;
            }

            if ($requestSyncProduct->externalId) {
                $syncProduct['external_id'] = $requestSyncProduct->externalId;
            }

            $params['sync_product'] = $syncProduct;
        }

        if ($requestSyncVariants) {
            $syncVariants = [];
            foreach ($requestSyncVariants as $requestSyncVariant) {
                $syncVariants[] = $requestSyncVariant->toPutArray();
            }
            $params['sync_variants'] = $syncVariants;
        }

        return $params;
    }
}

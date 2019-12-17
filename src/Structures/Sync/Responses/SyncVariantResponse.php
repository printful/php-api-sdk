<?php

namespace Printful\Structures\Sync\Responses;

use Printful\Structures\BaseItem;
use Printful\Structures\File;

class SyncVariantResponse extends BaseItem
{
    /** @var int */
    public $id;

    /** @var string */
    public $externalId;

    /** @var int */
    public $syncProductId;

    /** @var string */
    public $name;

    /** @var bool */
    public $synced;

    /** @var int */
    public $variantId;

    /** @var float */
    public $retailPrice;

    /** @var string */
    public $currency;

    /** @var SyncVariantProductResponse */
    public $product;

    /** @var File[] */
    public $files = [];

    /** @var SyncVariantOptionResponse[] */
    public $options = [];

    /**
     * Creates SyncVariantResponse from array
     *
     * @param array $array
     * @return SyncVariantResponse
     */
    public static function fromArray(array $array)
    {
        $variant = new SyncVariantResponse;

        $variant->id = (int)$array['id'];
        $variant->externalId = (string)$array['external_id'];
        $variant->syncProductId = (string)$array['sync_product_id'];
        $variant->name = (string)$array['name'];
        $variant->synced = (bool)$array['synced'];
        $variant->variantId = (int)$array['variant_id'];
        $variant->retailPrice = (float)$array['retail_price'];
        $variant->currency = (string)$array['currency'];
        $variant->product = SyncVariantProductResponse::fromArray($array['product']);

        $variantFiles = (array)$array['files'] ?: [];
        foreach ($variantFiles as $file) {
            $variant->files[] = File::fromArray($file);
        }

        $variantOptions = (array)$array['options'] ?: [];
        foreach ($variantOptions as $option) {
            $variant->options[] = SyncVariantOptionResponse::fromArray($option);
        }

        return $variant;
    }
}

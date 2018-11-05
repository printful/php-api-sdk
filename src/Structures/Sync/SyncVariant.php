<?php

namespace Printful\Structures\Sync;

use Printful\Structures\BaseItem;

class SyncVariant extends BaseItem
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

    /** @var SyncVariantProduct */
    public $product;

    /** @var SyncVariantFile[] */
    public $files = [];

    /** @var SyncVariantOption[] */
    public $options = [];

    /**
     * Creates SyncVariant from array
     *
     * @param array $array
     * @return SyncVariant
     */
    public static function fromArray(array $array)
    {
        $variant = new SyncVariant;

        $variant->id = (int)$array['id'];
        $variant->externalId = (string)$array['existing_id'];
        $variant->syncProductId = (string)$array['sync_product_id'];
        $variant->name = (string)$array['name'];
        $variant->synced = (bool)$array['synced'];
        $variant->variantId = (int)$array['variant_id'];
        $variant->retailPrice = (float)$array['retail_price'];
        $variant->currency = (string)$array['currency'];
        $variant->product = SyncVariantProduct::fromArray($array['product']);

        $variantFiles = (array)$array['files'] ?: [];
        foreach ($variantFiles as $file) {
            $variant->files[] = SyncVariantFile::fromArray($file);
        }

        $variantOptions = (array)$array['options'] ?: [];
        foreach ($variantOptions as $option) {
            $variant->options[] = SyncVariantOption::fromArray($option);
        }

        return $variant;
    }
}

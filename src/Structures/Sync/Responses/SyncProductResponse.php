<?php

namespace Printful\Structures\Sync\Responses;

class SyncProductResponse
{
    /** @var int */
    public $id;

    /** @var string */
    public $externalId;

    /** @var string */
    public $name;

    /** @var int */
    public $variants = 0;

    /** @var int */
    public $synced = 0;

    /**
     * Creates SyncProduct from array
     *
     * @param array $array
     * @return SyncProductResponse
     */
    public static function fromArray(array $array)
    {
        $syncProduct = new SyncProductResponse;

        $syncProduct->id = (int)$array['id'];
        $syncProduct->externalId = (string)$array['external_id'];
        $syncProduct->name = (string)$array['name'];
        $syncProduct->variants = (int)$array['variants'];
        $syncProduct->synced = (int)$array['synced'];

        return $syncProduct;
    }
}
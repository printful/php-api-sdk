<?php

namespace Printful\Structures\Sync\Responses;

class SyncVariantOptionResponse
{
    /** @var string */
    public $id;

    /** @var mixed */
    public $value;

    /**
     * Creates SyncVariantOptionResponse from array
     *
     * @param array $array
     * @return SyncVariantOptionResponse
     */
    public static function fromArray(array $array)
    {
        $option = new SyncVariantOptionResponse;

        $option->id = (string)$array['id'];
        $option->value = $array['value'];

        return $option;
    }
}
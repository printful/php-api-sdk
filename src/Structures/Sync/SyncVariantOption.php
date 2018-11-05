<?php

namespace Printful\Structures\Sync;

class SyncVariantOption
{
    /** @var string */
    public $id;

    /** @var mixed */
    public $value;

    /**
     * Creates SyncVariantOption from array
     *
     * @param array $array
     * @return SyncVariantOption
     */
    public static function fromArray(array $array)
    {
        $option = new SyncVariantOption;

        $option->id = (string)$array['id'];
        $option->value = $array['value'];

        return $option;
    }
}
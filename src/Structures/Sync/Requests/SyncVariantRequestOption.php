<?php

namespace Printful\Factories\Sync\Requests;

class SyncVariantRequestOption
{
    /** @var string */
    public $key;

    /** @var mixed */
    public $value;

    /**
     * Builds
     *
     * @param array $array
     * @return SyncVariantRequestOption
     */
    public static function fromArray(array $array)
    {
        $option = new SyncVariantRequestOption;

        $option->key = isset($array['key']) ? (string)$array['key'] : null;
        $option->value = isset($array['value']) ?: null;

        return $option;
    }
}
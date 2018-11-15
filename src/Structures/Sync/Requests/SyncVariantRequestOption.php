<?php

namespace Printful\Structures\Sync\Requests;

class SyncVariantRequestOption
{
    /** @var string */
    public $id;

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

        $option->id = isset($array['id']) ? (string)$array['id'] : null;
        $option->value = isset($array['value']) ?: null;

        return $option;
    }

    /**
     * Builds array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'key' => $this->id,
            'value' => $this->value,
        ];
    }
}
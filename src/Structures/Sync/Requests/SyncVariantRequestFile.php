<?php

namespace Printful\Factories\Sync\Requests;

class SyncVariantRequestFile
{
    const DEFAULT_TYPE = 'default';

    /** @var string */
    public $type;

    /** @var int */
    public $id;

    /** @var string */
    public $url;

    /**
     * Builds SyncVariantRequestFile from array
     *
     * @param array $array
     * @return SyncVariantRequestFile
     */
    public static function fromArray(array $array)
    {
        $file = new SyncVariantRequestFile;

        $file->type = isset($array['type']) ? (string)$array['type'] : null;
        $file->id = isset($array['id']) ? (int)$array['id'] : null;
        $file->url = isset($array['url']) ? (string)$array['url'] : null;

        return $file;
    }
}

<?php

namespace Printful\Structures\Sync\Requests;

class SyncVariantRequestFile
{
    const DEFAULT_TYPE = 'default';

    /** @var string */
    public $type = self::DEFAULT_TYPE;

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

        $file->type = isset($array['type']) ? (string)$array['type'] : self::DEFAULT_TYPE;
        $file->id = isset($array['id']) ? (int)$array['id'] : null;
        $file->url = isset($array['url']) ? (string)$array['url'] : null;

        return $file;
    }
}

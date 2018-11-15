<?php

namespace Printful\Structures\Sync\Requests;

use Printful\Exceptions\PrintfulSdkException;
use Printful\Structures\File;

class SyncVariantRequestFile
{
    /** @var string */
    public $type = File::TYPE_DEFAULT;

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

        $file->type = isset($array['type']) ? (string)$array['type'] : File::TYPE_DEFAULT;
        $file->id = isset($array['id']) ? (int)$array['id'] : null;
        $file->url = isset($array['url']) ? (string)$array['url'] : null;

        return $file;
    }

    /**
     * Builds array for request
     *
     * @return array
     * @throws PrintfulSdkException
     */
    public function toArray()
    {
        $fileParam = [];

        if ($this->id && $this->url) {
            throw new PrintfulSdkException('Cannot specify both file id and url parameters');
        } elseif (!$this->id && !$this->url) {
            throw new PrintfulSdkException('Must specify file id or url parameter');
        }

        if ($this->id) {
            $fileParam['id'] = $this->id;
        }

        if ($this->url) {
            $fileParam['url'] = $this->url;
        }

        if ($this->type) {
            $fileParam['type'] = $this->type;
        }

        return $fileParam;
    }
}

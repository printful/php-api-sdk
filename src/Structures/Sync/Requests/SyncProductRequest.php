<?php

namespace Printful\Structures\Sync\Requests;

class SyncProductRequest
{
    /** @var string */
    public $externalId;

    /** @var string */
    public $name;

    /** @var string */
    public $thumbnail = '';

    /**
     * Builds SyncProductRequest from array
     *
     * @param array $array
     * @return SyncProductRequest
     */
    public static function fromArray(array $array)
    {
        $syncProductRequest = new SyncProductRequest;

        $syncProductRequest->name = isset($array['name']) ? (string)$array['name'] : null;
        $syncProductRequest->thumbnail = isset($array['thumbnail']) ? (string)$array['thumbnail'] : null;
        $syncProductRequest->externalId = isset($array['external_id']) ? (string)$array['external_id'] : null;

        return $syncProductRequest;
    }
}

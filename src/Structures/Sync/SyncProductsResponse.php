<?php

namespace Printful\Structures\Sync;

class SyncProductsResponse
{
    /** @var SyncProduct[] */
    public $result = [];

    /** @var SyncProductsPaging */
    public $paging;

    /**
     * Creates SyncProductsResponse from request array
     *
     * @param array $array
     * @return SyncProductsResponse
     */
    public static function fromArray(array $array)
    {
        $response = new SyncProductsResponse();

        $result = $array['result'] ?: [];
        foreach ($result as $item) {
            $response->result[] = SyncProduct::fromArray($item);
        }

        $pagingArray = $array['paging'] ?: [];
        $response->paging = SyncProductsPaging::fromArray($pagingArray);

        return $response;
    }
}
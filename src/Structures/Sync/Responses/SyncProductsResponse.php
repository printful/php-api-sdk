<?php

namespace Printful\Structures\Sync\Responses;

class SyncProductsResponse
{
    /** @var SyncProductResponse[] */
    public $result = [];

    /** @var SyncProductsPagingResponse */
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
            $response->result[] = SyncProductResponse::fromArray($item);
        }

        $pagingArray = $array['paging'] ?: [];
        $response->paging = SyncProductsPagingResponse::fromArray($pagingArray);

        return $response;
    }
}
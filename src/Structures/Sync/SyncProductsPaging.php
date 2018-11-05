<?php

namespace Printful\Structures\Sync;

class SyncProductsPaging
{
    /** @var int */
    public $offset = 0;
    /** @var int */
    public $limit = 20;
    /** @var int */
    public $total = 0;

    /**
     * Creates SyncProductPaging from array
     *
     * @param array $array
     * @return SyncProductsPaging
     */
    public static function fromArray(array $array)
    {
        $paging = new SyncProductsPaging;

        $paging->total =(int)$array['total'] ?: 0;
        $paging->limit =(int)$array['limit'] ?: 0;
        $paging->offset =(int)$array['offset'] ?: 0;

        return $paging;
    }
}
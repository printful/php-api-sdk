<?php

namespace Printful\Structures\Store;

use Printful\Structures\BaseItem;

class StoreStatisticsItem extends BaseItem
{
    /**
     * @var int
     */
    public $orders;

    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $trend;

    /**
     * @param array $raw
     * @return StoreStatisticsItem
     */
    public static function fromArray(array $raw)
    {
        $statsItem = new self;
        $statsItem->orders = $raw['orders'];
        $statsItem->total = $raw['total'];
        $statsItem->trend = $raw['trend'];
        return $statsItem;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'orders' => $this->orders,
            'total' => $this->total,
            'profit' => $this->trend,
        ];
    }
}
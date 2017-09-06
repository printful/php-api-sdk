<?php

namespace Printful\Structures\Store;

use Printful\Structures\BaseItem;

class StoreStatistics extends BaseItem
{
    /**
     * @var StoreStatisticsItem
     */
    public $orders_today;

    /**
     * @var StoreStatisticsItem
     */
    public $orders_last_7_days;

    /**
     * @var StoreStatisticsItem
     */
    public $orders_last_28_days;

    /**
     * @var string
     */
    public $profit_last_28_days;

    /**
     * @var string
     */
    public $profit_trend_last_28_days;

    /**
     * @param array $raw
     * @return StoreStatistics
     */
    public static function fromArray(array $raw)
    {
        $stats = new self;
        $stats->orders_today = StoreStatisticsItem::fromArray($raw['orders_today']);
        $stats->orders_last_7_days = StoreStatisticsItem::fromArray($raw['orders_last_7_days']);
        $stats->orders_last_28_days = StoreStatisticsItem::fromArray($raw['orders_last_28_days']);
        $stats->profit_last_28_days = $raw['profit_last_28_days'];
        $stats->profit_trend_last_28_days = $raw['profit_trend_last_28_days'];

        return $stats;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'orders_today' => $this->orders_today->toArray(),
            'orders_last_7_days' => $this->orders_last_7_days->toArray(),
            'orders_last_28_days' => $this->orders_last_28_days->toArray(),
            'profit_last_28_days' => $this->profit_last_28_days,
            'profit_trend_last_28_days' => $this->profit_trend_last_28_days,
        ];
    }
}
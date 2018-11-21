<?php

namespace Printful\Structures\Order;

class OrderCostGroup
{
    /** @var OrderCostsItem|null */
    public $printfulCosts;

    /** @var OrderCostsItem|null */
    public $retailCosts;

    /**
     * @param array $raw
     * @return OrderCostGroup
     */
    public static function fromArray(array $raw)
    {
        $orderCosts = new self;

        $orderCosts->printfulCosts = !empty($raw['costs']) ? OrderCostsItem::fromArray($raw['costs']) : null;
        $orderCosts->retailCosts = !empty($raw['retail_costs']) ? OrderCostsItem::fromArray($raw['retail_costs']) : null;

        return $orderCosts;
    }
}

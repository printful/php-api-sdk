<?php

namespace Printful\Structures\Order;

class OrderList
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $offset;

    /**
     * @var array
     */
    public $orders = [];

    /**
     * @param array $rawOrders
     * @param int $total
     * @param int $offset
     */
    public function __construct(array $rawOrders, $total, $offset)
    {
        $this->total = $total;
        $this->offset = $offset;

        foreach ($rawOrders as $v) {
            $this->orders[] = Order::fromArray($v);
        }
    }
}
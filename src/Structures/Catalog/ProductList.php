<?php

namespace Printful\Structures\Catalog;

class ProductList
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
    public $products = [];

    /**
     * @param array $rawProducts
     * @param int $total
     * @param int $offset
     */
    public function __construct(array $rawProducts, $total, $offset)
    {
        $this->total = $total;
        $this->offset = $offset;

        foreach ($rawProducts as $v) {
            $this->products[] = Product::fromArray($v);
        }
    }
}
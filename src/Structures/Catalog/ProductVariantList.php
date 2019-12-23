<?php

namespace Printful\Structures\Catalog;

class ProductVariantList
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var array
     */
    public $variants = [];

    /**
     * @param array $rawProducts
     * @param int $total
     * @param int $offset
     */
    public function __construct(array $rawVariants, $total)
    {
        $this->total = $total;

        foreach ($rawVariants as $v) {
            $this->variants[] = ProductVariant::fromArray($v);
        }
    }
}
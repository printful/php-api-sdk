<?php


namespace Printful\Structures\Generator;


class ProductPrintfiles
{
    /**
     * @var int
     */
    public $productId;

    /**
     * List of available file placements (front, back, etc) for this file.
     * Key is placement id, value is display title
     *
     * @var array
     */
    public $availablePlacements = [];

    /**
     * List of all unique printfiles for this product
     *
     * @var PrintfileItem[]
     */
    public $printfiles = [];

    /**
     * List of all product variants, their placements and placement printfiles
     *
     * @var VariantPrintfileItem[]
     */
    public $variantPrintfiles = [];
}
<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class ProductVariant extends BaseItem
{
    /**
     * @var int
     */
    public $variant_id;

    /**
     * @var int
     */
    public $product_id;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $name;

    /**
     * @param array $raw
     * @return ProductVariant
     */
    public static function fromArray(array $raw)
    {
        $variant = new self;

        $variant->variant_id = (int)$raw['variant_id'];
        $variant->product_id = (int)$raw['product_id'];
        $variant->image = $raw['image'];
        $variant->name = $raw['name'];

        return $variant;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'variantId' => $this->variant_id,
            'productId' => $this->product_id,
            'image' => $this->image,
            'name' => $this->name,
        ];
    }
}
<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class OrderLineItem extends BaseItem
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string - Line item ID from the external system
     */
    public $externalId;

    /**
     * @var int
     */
    public $variantId;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $price;

    /**
     * @var string|null - Original retail price of the item to be displayed on the packing slip
     */
    public $retailPrice;

    /**
     * @var string - Display name of the item. If not given, a name from the Printful system will be displayed on the packing slip
     */
    public $name;

    /**
     * @var OrderItemFile[]
     */
    public $files = [];

    /**
     * @var ProductVariant
     */
    public $product;

    /**
     * @var OrderItemOption[]
     */
    public $options = [];

    /**
     * @var string - Product identifier (SKU) from the external system
     */
    public $sku;

    /**
     * @param array $raw
     * @return OrderLineItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->id = (int)$raw['id'];
        $item->externalId = $raw['external_id'];
        $item->variantId = (int)$raw['variant_id'];
        $item->quantity = (int)$raw['quantity'];
        $item->price = (float)$raw['price'];
        $item->retailPrice = (float)$raw['retail_price'];
        $item->name = $raw['name'];
        $item->product = ProductVariant::fromArray($raw['product']);
        $item->sku = $raw['sku'];

        foreach ($raw['files'] as $v) {
            $item->files[] = OrderItemFile::fromArray($v);
        }

        foreach ($raw['options'] as $v) {
            $item->options[] = OrderItemOption::fromArray($v);
        }

        return $item;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        // Format Item print files
        $files = [];
        foreach ($this->files as $v) {
            $files[] = $v->toArray();
        }

        $options = [];
        foreach ($this->options as $v) {
            $options[] = $v->toArray();
        }

        return [
            'externalId' => $this->externalId,
            'variantId' => $this->variantId,
            'quantity' => $this->quantity,
            'retailPrice' => (float)$this->retailPrice,
            'name' => $this->name,
            'sku' => $this->sku,
            'options' => $options,
            'files' => $files,
        ];
    }
}

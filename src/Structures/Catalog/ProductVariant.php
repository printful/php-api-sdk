<?php

namespace Printful\Structures\Catalog;

use Printful\Structures\BaseItem;

class ProductVariant extends BaseItem
{

	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var integer
	 */
	public $productId;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $size;

	/**
	 * @var string
	 */
	public $color;

	/**
	 * @var string
	 */
	public $colorCode;

	/**
	 * @var string
	 */
	public $colorCode2;

	/**
	 * @var string
	 */
	public $image;

	/**
	 * @var string
	 */
	public $price;

	/**
	 * @var boolean
	 */
	public $inStock;

	/**
	 * @var array
	 */
	public $availabilityRegions;

	/**
	 * @param array $raw
	 * @return ProductVariant
	 */
	public static function fromArray(array $raw)
	{
		$variant = new self;

		$variant->id = $raw['id'];
		$variant->productId = $raw['product_id'];
		$variant->name = $raw['name'];
		$variant->size = $raw['size'];
		$variant->color = $raw['color'];
		$variant->colorCode = $raw['color_code'];
		$variant->colorCode2 = $raw['color_code2'];
		$variant->image = $raw['image'];
		$variant->price = $raw['price'];
		$variant->inStock = $raw['in_stock'];
		$variant->availabilityRegions = $raw['availability_regions'];

		return $variant;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'id' => $this->id,
			'product_id' => $this->productId,
			'name' => $this->name,
			'size' => $this->size,
			'color' => $this->color,
			'color_code' => $this->colorCode,
			'color_code2' => $this->colorCode2,
			'image' => $this->image,
			'price' => $this->price,
			'in_stock' => $this->inStock,
			'availability_regions' => $this->availabilityRegions,
		];
	}
}

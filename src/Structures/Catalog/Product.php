<?php

namespace Printful\Structures\Catalog;

use Printful\Structures\BaseItem;

class Product extends BaseItem
{
    /**
     * @var integer
     */
    public $id;

	/**
	 * @var string
	 */
    public $type;

    /**
     * @var string
     */
    public $typeName;

	/**
	 * @var string
	 */
    public $brand;

	/**
	 * @var string
	 */
    public $model;

	/**
	 * @var string
	 */
    public $image;

	/**
	 * @var integer
	 */
    public $variantCount;

	/**
	 * @var string
	 */
    public $currency;

	/**
	 * @var ProductFile[]
	 */
    public $files;

	/**
	 * @var ProductOption[]
	 */
    public $options;

	/**
	 * @var boolean
	 */
    public $isDiscontinued;

	/**
	 * @var string
	 */
    public $description;

	/**
	 * @var array
	 */
    public $dimensions;

    /**
     * @param array $raw
     * @return Product
     */
    public static function fromArray(array $raw)
    {
        $product = new Product();

		$product->id = (int)$raw['id'];
		$product->type = $raw['type'];
		$product->typeName = $raw['type_name'];
		$product->brand = $raw['brand'];
		$product->model = $raw['model'];
		$product->image = $raw['image'];
		$product->variantCount = $raw['variant_count'];
		$product->currency = $raw['currency'];
		foreach ($raw['files'] as $v) {
			$product->files[] = ProductFile::fromArray($v);
		}

		foreach ($raw['options'] as $v) {
			$product->options[] = ProductOption::fromArray($v);
		}
		$product->isDiscontinued = $raw['is_discontinued'];
		$product->description = $raw['description'];
		$product->dimensions = $raw['dimensions'];

        return $product;
    }
}

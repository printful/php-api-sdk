<?php

namespace Printful\Structures\Catalog;

class ProductOption extends BaseItem
{

	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $type;

	/**
	 * @var array
	 */
	public $values;

	/**
	 * @var string
	 */
	public $additionalPrice;

	/**
	 * @var array
	 */
	public $additionalPriceBreakdown;


	/**
	 * @param array $raw
	 * @return ProductOption
	 */
	public static function fromArray(array $raw)
	{
		$option = new self;

		$option->id = $raw['id'];
		$option->title = $raw['title'];
		$option->type = $raw['type'];
		$option->values = $raw['values'];
		$option->additionalPrice = $raw['additional_price'];
		$option->additionalPriceBreakdown = $raw['additional_price_breakdown'];

		return $option;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'type' => $this->type,
			'values' => $this->values,
			'additional_price' => $this->additionalPrice,
			'additional_price_breakdown' => $this->additionalPriceBreakdown,
		];
	}
}

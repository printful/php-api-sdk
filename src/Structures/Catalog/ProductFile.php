<?php

namespace Printful\Structures\Catalog;

use Printful\Structures\BaseItem;

class ProductFile extends BaseItem
{
	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var string
	 */
	public $type;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $additionalPrice;

	/**
	 * @var int
	 */
	public $size;

	/**
	 * @var int
	 */
	public $width;

	/**
	 * @var int
	 */
	public $height;

	/**
	 * @var int
	 */
	public $dpi;

	/**
	 * @var string
	 * ok - file was processed successfully
	 * waiting - file is being processed
	 * failed - file failed to be processed
	 */
	public $status;

	/**
	 * @var int - Timestamp
	 */
	public $created;

	/**
	 * @var string
	 */
	public $thumbnailUrl;

	/**
	 * @var string
	 */
	public $previewUrl;

	/**
	 * @var bool
	 * Show file in the Printfile Library (default true)
	 */
	public $visible;

	/**
	 * @param array $raw
	 * @return ProductFile
	 */
	public static function fromArray(array $raw)
	{
		$file = new self;

		$file->id = (int)$raw['id'];
		$file->type = $raw['type'];
		$file->title = $raw['title'];
		$file->additionalPrice = $raw['additional_price'];

		return $file;
	}


	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'id' => $this->id,
			'type' => $this->type,
			'title' => $this->title,
			'additional_price' => $this->additionalPrice,
		];
	}
}

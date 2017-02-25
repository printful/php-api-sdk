<?php

namespace Printful\Structures\Order;

class OrderItemCreationParameters
{
    /**
     * @var string - Line item ID from the external system
     */
    public $externalId;

    /**
     * @var int - Variant ID of the item ordered
     */
    public $variantId;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string|null - Original retail price of the item to be displayed on the packing slip
     */
    public $retailPrice;

    /**
     * @var string - Display name of the item. If not given, a name from the Printful system will be displayed on the packing slip
     */
    public $name;

    /**
     * @var string - Product identifier (SKU) from the external system
     */
    public $sku;

    /**
     * @var OrderItemFile[]
     */
    private $files = [];

    /**
     * @var OrderItemOption[]
     */
    private $options = [];

    /**
     * There are two ways to assign a print file to the item.
     * One is to specify the File ID if the file already exists in the file library of the authorized store
     * The second and the most convenient method is to specify the file URL.
     * If a file with the same URL already exists, it will be reused
     *
     * @param string $type - Role of the file in the order
     * @param string $url - Source URL where the file is downloaded from
     * @param string|null $filename
     * @param int|null $id - ID if the file already exists in the Printfile Library
     * @param bool $isVisible - Show file in the Printfile Library (default true)
     */
    public function addFile($type, $url, $filename = null, $id = null, $isVisible = true)
    {
        $this->files[] = [
            'type' => $type,
            'url' => $url,
            'filename' => $filename,
            'id' => $id,
            'visible' => $isVisible,
        ];
    }

    /**
     * @param string $id
     * @param string $value
     */
    public function addOption($id, $value)
    {
        $this->options[] = [
            'id' => $id,
            'value' => $value,
        ];
    }

    /**
     * @return OrderItemFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return OrderItemOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'external_id' => $this->externalId,
            'variant_id' => $this->variantId,
            'quantity' => $this->quantity,
            'retail_price' => $this->retailPrice,
            'name' => $this->name,
            'sku' => $this->sku,
            'files' => $this->files,
            'options' => $this->options,
        ];
    }
}

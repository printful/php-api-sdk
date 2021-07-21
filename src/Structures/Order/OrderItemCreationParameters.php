<?php

namespace Printful\Structures\Order;

use Printful\Structures\File;

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
     * @var int - SyncVariant ID of the item ordered
     */
    public $syncVariantId;

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
     * @var File[]|null
     */
    private $files;

    /**
     * @var OrderItemOption[]|null
     */
    private $options;

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
        $this->files = is_null($this->files)
            ? []
            : $this->files;

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
        $this->options = is_null($this->options)
            ? []
            : $this->options;

        $this->options[] = [
            'id' => $id,
            'value' => $value,
        ];
    }

    /**
     * @return File[]|null
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return OrderItemOption[]|null
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
        $array = [
            'external_id' => $this->externalId,
            'quantity' => $this->quantity,
            'retail_price' => $this->retailPrice,
            'name' => $this->name,
            'sku' => $this->sku,
        ];

        if (!is_null($this->variantId)) {
            $array['variant_id'] = $this->variantId;
        }

        if (!is_null($this->syncVariantId)) {
            $array['sync_variant_id'] = $this->syncVariantId;
        }

        if (!is_null($this->files)) {
            $array['files'] = $this->files;
        }

        if (!is_null($this->options)) {
            $array['options'] = $this->options;
        }

        return $array;
    }
}

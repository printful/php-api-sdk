<?php

namespace Printful\Structures\Sync\Requests;

class SyncVariantRequest
{
    /** @var int|null */
    public $id;

    /** @var string|null */
    public $externalId;

    /** @var int|null */
    public $variantId;

    /** @var float|null */
    public $retailPrice;

    /** @var SyncVariantRequestFile[]|null */
    private $files;

    /** @var SyncVariantRequestOption[]|null */
    private $options;

    /**
     * Adds SyncVariantRequestFile to SyncVariantRequest
     *
     * @param SyncVariantRequestFile $file
     */
    public function addFile(SyncVariantRequestFile $file)
    {
        if (is_null($this->files)) {
            $this->files = [];
        }

        $this->files[] = $file;
    }

    /**
     * Returns SyncVariantRequestFile array added to SyncVariantRequest
     *
     * @return SyncVariantRequestFile[]|null
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Adds SyncVariantRequestOption to SyncVariantRequest
     *
     * @param SyncVariantRequestOption $option
     */
    public function addOption(SyncVariantRequestOption $option)
    {
        if (is_null($this->options)) {
            $this->options = [];
        }

        $this->options[] = $option;
    }

    /**
     * Returns SyncVariantRequestOption array added to SyncVariantRequest
     *
     * @return SyncVariantRequestOption[]|null
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Builds SyncVariantRequest from array
     *
     * @param array $array
     * @return SyncVariantRequest
     */
    public static function fromArray(array $array)
    {
        $syncVariantRequest = new SyncVariantRequest;

        $syncVariantRequest->externalId = isset($array['external_id']) ? (string)$array['external_id'] : null;
        $syncVariantRequest->variantId = isset($array['variant_id']) ? (int)$array['variant_id'] : null;
        $syncVariantRequest->retailPrice = isset($array['retail_price']) ? (float)$array['retail_price'] : null;

        $syncVariantRequestFiles = isset($array['files']) ? (array)$array['files'] : [];
        foreach ($syncVariantRequestFiles as $syncVariantRequestFile) {
            $file = SyncVariantRequestFile::fromArray($syncVariantRequestFile);
            $syncVariantRequest->addFile($file);
        }

        $syncVariantRequestOptions = isset($array['options']) ? (array)$array['options'] : [];
        foreach ($syncVariantRequestOptions as $syncVariantRequestOption) {
            $option = SyncVariantRequestOption::fromArray($syncVariantRequestOption);
            $syncVariantRequest->addOption($option);
        }

        return $syncVariantRequest;
    }
}

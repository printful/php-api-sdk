<?php

namespace Printful\Structures\Sync\Requests;

use Printful\Factories\Sync\Requests\SyncVariantRequestFile;
use Printful\Factories\Sync\Requests\SyncVariantRequestOption;

class SyncVariantRequest
{
    /** @var string */
    public $externalId;

    /** @var int */
    public $variantId;

    /** @var float */
    public $retailPrice;

    /** @var SyncVariantRequestFile[] */
    private $files = [];

    /** @var SyncVariantRequestOption[] */
    private $options = [];

    /**
     * Adds SyncVariantRequestFile to SyncVariantRequest
     *
     * @param SyncVariantRequestFile $file
     */
    public function addFile(SyncVariantRequestFile $file)
    {
        $this->files[] = $file;
    }

    /**
     * Returns SyncVariantRequestFile array added to SyncVariantRequest
     *
     * @return SyncVariantRequestFile[]
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
        $this->options[] = $option;
    }

    /**
     * Returns SyncVariantRequestOption array added to SyncVariantRequest
     *
     * @return SyncVariantRequestOption[]
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

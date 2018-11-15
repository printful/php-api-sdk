<?php

namespace Printful\Structures\Sync\Requests;

use Printful\Exceptions\PrintfulSdkException;

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

    /**
     * Builds POST request array
     *
     * @return array
     * @throws PrintfulSdkException
     */
    public function toPostArray()
    {
        if (!$this->variantId) {
            throw new PrintfulSdkException('Missing variant_id');
        }

        $files = $this->getFiles();
        if (empty($files)) {
            throw new PrintfulSdkException('Missing files');
        }

        $syncVariantParams = [];

        $syncVariantParams['external_id'] = $this->externalId;
        $syncVariantParams['retail_price'] = $this->retailPrice;
        $syncVariantParams['variant_id'] = $this->variantId;

        $syncVariantParams['files'] = [];
        foreach ($files as $file) {
            $syncVariantParams['files'][] = $file->toArray();
        }

        $syncVariantParams['options'] = [];
        foreach ($this->getOptions() as $option) {
            $syncVariantParams['options'][] = $option->toArray();
        }

        return $syncVariantParams;
    }

    /**
     * Builds PUT request array
     *
     * @return array
     * @throws PrintfulSdkException
     */
    public function toPutArray()
    {
        $syncVariantParams = [];

        if (!is_null($this->externalId)) {
            $syncVariantParams['external_id'] = $this->externalId;
        }

        if (!is_null($this->retailPrice)) {
            $syncVariantParams['retail_price'] = $this->retailPrice;
        }

        if (!is_null($this->variantId)) {
            if (!$this->variantId) {
                throw new PrintfulSdkException('Variant id is required');
            }

            $syncVariantParams['variant_id'] = $this->variantId;
        }

        $files = $this->getFiles();
        if (!is_null($files)) {
            $syncVariantParams['files'] = [];
            foreach ($files as $file){
                $syncVariantParams['files'][] = $file->toArray();
            }
        }

        $options = $this->getOptions();
        if (!is_null($options)) {
            $syncVariantParams['options'] = [];
            foreach ($options as $option) {
                $syncVariantParams['options'][] = $option->toArray();
            }
        }

        return $syncVariantParams;
    }
}

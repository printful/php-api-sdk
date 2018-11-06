<?php

namespace Printful\Factories\Sync;

use Printful\Exceptions\PrintfulSdkException;
use Printful\Factories\Sync\Requests\SyncVariantRequestFile;
use Printful\Factories\Sync\Requests\SyncVariantRequestOption;
use Printful\Structures\Sync\SyncProductCreationParameters;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

class ParameterFactory
{
    /**
     * Builds SyncProduct POST request params
     *
     * @param SyncProductCreationParameters $request
     * @return array
     * @throws PrintfulSdkException
     */
    public static function buildSyncProductPostParams(SyncProductCreationParameters $request)
    {
        $params = [];

        $requestProduct = $request->getProduct();
        $syncProductParams = [];

        if (empty($requestProduct->name)) {
            throw new PrintfulSdkException('Missing product name');
        }

        $syncProductParams['name'] = $requestProduct->name;
        if (!empty($requestProduct->thumbnail)) {
            $syncProductParams['thumbnail'] = (string)$requestProduct->thumbnail;
        }
        $params['sync_product'] = $syncProductParams;

        $syncVariantParams = [];
        foreach ($request->getVariants() as $variant) {
            $syncVariantParams[] = self::buildSyncVariantPostParams($variant);
        }

        if (empty($syncVariantParams)) {
            throw new PrintfulSdkException('No variants specified');
        }

        $params['sync_variants'] = $syncVariantParams;

        return $params;
    }

    /**
     * Builds POST params from SyncVariantRequest
     *
     * @param SyncVariantRequest $syncVariantRequest
     * @return array
     * @throws PrintfulSdkException
     */
    public static function buildSyncVariantPostParams(SyncVariantRequest $syncVariantRequest)
    {
        if (!$syncVariantRequest->variantId) {
            throw new PrintfulSdkException('Missing variant_id');
        }

        $files = $syncVariantRequest->getFiles();
        if (empty($files)) {
            throw new PrintfulSdkException('Missing files');
        }

        $syncVariantParams = [];

        $syncVariantParams['retail_price'] = $syncVariantRequest->retailPrice;
        $syncVariantParams['variant_id'] = $syncVariantRequest->variantId;
        $syncVariantParams['files'] = self::buildSyncVariantFilesParam($files);
        $syncVariantParams['options'] = self::buildSyncVariantOptionsParam($syncVariantRequest->getOptions());

        return $syncVariantParams;
    }

    /**
     * Builds SyncVariantRequest options param
     *
     * @param SyncVariantRequestOption[] $options
     * @return array
     */
    private static function buildSyncVariantOptionsParam(array $options)
    {
        $params = [];

        foreach ($options as $option) {
            $params[] = [
                'key' => $option->key,
                'value' => $option->value,
            ];
        }

        return $params;
    }

    /**
     * Builds SyncVariantRequest files param
     *
     * @param SyncVariantRequestFile[]
     * @return array
     * @throws PrintfulSdkException
     */
    private static function buildSyncVariantFilesParam(array $files)
    {
        $filesParams = [];
        foreach ($files as $file) {
            $fileParam = [];
            if ($file->id && $file->url) {
                throw new PrintfulSdkException('Cannot specify both file id and url parameters');
            } elseif (!$file->id && !$file->url) {
                throw new PrintfulSdkException('Must specify file id or url parameter');
            }

            if ($file->id) {
                $filesParams['id'] = $file->id;
            }

            if ($file->url) {
                $filesParams['url'] = $file->url;
            }

            $key = SyncVariantRequestFile::DEFAULT_TYPE;
            if ($file->type) {
                $key = $file->type;
                $fileParam['type'] = $file->type;
            }

            // one file per position
            $filesParams[$key] = $fileParam;
        }

        return array_values($filesParams);
    }
}

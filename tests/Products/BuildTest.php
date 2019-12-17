<?php

namespace Printful\Tests\Products;

use Printful\Structures\File;
use Printful\Structures\Sync\Requests\SyncVariantRequestFile;
use Printful\Structures\Sync\SyncProductCreationParameters;

class BuildTest extends ProductsTestBase
{
    /**
     * Tests SyncProductCreationParameters build from array
     */
    public function testProductCreationParamsBuild()
    {
        $data = $this->getPostProductData();

        $params = SyncProductCreationParameters::fromArray($data);
        $this->assertInstanceOf(SyncProductCreationParameters::class, $params);

        $product = $params->getProduct();
        $variants = $params->getVariants();

        // assert product fields
        $this->assertEquals($product->name, $data['sync_product']['name']);
        $this->assertEquals($product->thumbnail, $data['sync_product']['thumbnail']);

        // assert variants
        $this->assertEquals(count($variants), count($data['sync_variants']));
        foreach ($variants as $variant) {
            $found = false;

            foreach ($data['sync_variants'] as $dataVariant) {
                if ($variant->variantId == $dataVariant['variant_id']) {
                    $this->assertEquals($dataVariant['retail_price'], $variant->retailPrice);

                    $files = $variant->getFiles();
                    $this->assertEquals(count($files), count($dataVariant['files']));
                    $this->compareFiles($files, $dataVariant['files']);

                    $options = $variant->getOptions();
                    $this->assertEquals(count($options), count($dataVariant['options']));

                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found);
        }
    }

    /**
     * @param SyncVariantRequestFile[] $files
     * @param array $dataFiles
     */
    private function compareFiles($files, $dataFiles)
    {
        foreach ($files as $file) {
            $found = false;

            foreach ($dataFiles as $dataFile) {
                $type = isset($dataFile['type']) ? $dataFile['type'] : File::TYPE_DEFAULT;
                if ($type == $file->type) {
                    $this->assertEquals($dataFile['url'], $file->url);

                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found);
        }
    }

    /**
     * Tests building Products POST params
     *
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testBuildProductPostParams()
    {
        $data = $this->getPostProductData();
        $creationParams = SyncProductCreationParameters::fromArray($data);
        $this->assertInstanceOf(SyncProductCreationParameters::class, $creationParams);

        $postParams = $creationParams->toPostArray();

        $this->assertEquals($postParams['sync_product'], $data['sync_product']);
        $this->assertEquals(count($postParams['sync_variants']), count($data['sync_variants']));

        foreach ($postParams['sync_variants'] as $postSyncVariant) {
            $found = false;
            foreach ($data['sync_variants'] as $dataSyncVariant) {
                if ($postSyncVariant['variant_id'] == $dataSyncVariant['variant_id']) {

                    $this->assertEquals($postSyncVariant['retail_price'], $dataSyncVariant['retail_price']);
                    $this->assertEquals(count($postSyncVariant['files']), count($dataSyncVariant['files']));

                    // actual file array compare we skip here

                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found);
        }

    }
}

<?php


namespace Printful;


use Printful\Structures\Generator\MockupGenerationFile;
use Printful\Structures\Generator\MockupGenerationParameters;
use Printful\Structures\Generator\MockupItem;
use Printful\Structures\Generator\MockupList;
use Printful\Structures\Generator\PrintfileItem;
use Printful\Structures\Generator\ProductPrintfiles;
use Printful\Structures\Generator\VariantPlacementGroup;
use Printful\Structures\Generator\VariantPrintfileItem;

class MockupGenerator
{
    /** @var PrintfulApiClient */
    private $printfulClient;

    /**
     * @param PrintfulApiClient $printfulClient
     */
    public function __construct(PrintfulApiClient $printfulClient)
    {
        $this->printfulClient = $printfulClient;
    }

    /**
     * Get all available templates for specific printful product
     *
     * @param int $productId Printful product id
     * @return ProductPrintfiles
     */
    public function getProductPrintfiles($productId)
    {
        $raw = $this->printfulClient->get('mockup-generator/printfiles/' . $productId);

        $productPrintfiles = new ProductPrintfiles;

        $productPrintfiles->productId = $raw['product_id'];
        $productPrintfiles->availablePlacements = $raw['available_placements'];
        $productPrintfiles->printfiles = [];
        $productPrintfiles->variantPrintfiles = [];

        foreach ($raw['printfiles'] as $v) {
            $printfileItem = PrintfileItem::fromArray($v);
            $productPrintfiles->printfiles[$printfileItem->printfileId] = $printfileItem;
        }

        foreach ($raw['variant_printfiles'] as $v) {
            $variantPrintfileItem = VariantPrintfileItem::fromArray($v);
            $productPrintfiles->variantPrintfiles[$variantPrintfileItem->variantId] = $variantPrintfileItem;
        }

        return $productPrintfiles;
    }

    /**
     * Merge variants in to unique printfile + placement groups.
     * This group can be used for positioning, that covers a list of variants
     *
     * @param ProductPrintfiles $productPrintfiles
     * @return VariantPlacementGroup[]
     */
    public function groupPrintfiles(ProductPrintfiles $productPrintfiles)
    {
        $re = [];

        foreach ($productPrintfiles->variantPrintfiles as $v) {
            foreach ($v->placements as $k2 => $v2) {
                $key = $k2 . '|' . $v2;

                $item = isset($re[$key]) ? $re[$key] : new VariantPlacementGroup;
                $item->placement = $k2;
                $item->variantIds[] = $v->variantId;
                $item->printfile = $productPrintfiles->printfiles[$v2];

                $re[$key] = $item;
            }
        }

        return array_values($re);
    }

    /**
     * Generate mockup images for given Printful product and variants.
     * This request can take up to multiple seconds!
     *
     * @param MockupGenerationParameters $parameters
     * @return MockupList
     */
    public function generateMockups(MockupGenerationParameters $parameters)
    {
        $files = array_map(function (MockupGenerationFile $file) {
            return [
                'placement' => $file->placement,
                'image_url' => $file->imageUrl,
            ];
        }, $parameters->getFiles());

        $data = [
            'variant_ids' => $parameters->variantIds,
            'files' => $files,
        ];

        $response = $this->printfulClient->post('/mockup-generator/generate/' . $parameters->productId, $data);

        $mockupList = new MockupList;

        $mockupList->productId = (int)$response['product_id'];

        $mockupList->mockups = array_map(function (array $rawMockup) {
            return MockupItem::fromArray($rawMockup);
        }, $response['mockups']);

        return $mockupList;
    }
}
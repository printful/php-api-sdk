<?php


namespace Printful;


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
}
<?php


namespace Printful;


use Printful\Structures\Generator\GenerationResultItem;
use Printful\Structures\Generator\MockupGenerationFile;
use Printful\Structures\Generator\MockupGenerationParameters;
use Printful\Structures\Generator\PrintfileItem;
use Printful\Structures\Generator\ProductPrintfiles;
use Printful\Structures\Generator\Templates\PlacementConflictItem;
use Printful\Structures\Generator\Templates\ProductTemplates;
use Printful\Structures\Generator\Templates\TemplateItem;
use Printful\Structures\Generator\Templates\VariantTemplateMappingItem;
use Printful\Structures\Generator\VariantPlacementGroup;
use Printful\Structures\Generator\VariantPrintfileItem;

class PrintfulMockupGenerator
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
     * @throws Exceptions\PrintfulException
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
     * Create an asynchronous generation task and return task that is in pending state
     * To retrieve the generation result use <b>PrintfulMockupGenerator::getGenerationTask</b> method.
     *
     * @param MockupGenerationParameters $parameters
     * @return GenerationResultItem Pending task
     * @throws Exceptions\PrintfulException
     * @see PrintfulMockupGenerator::getGenerationTask
     */
    public function createGenerationTask(MockupGenerationParameters $parameters)
    {
        $data = $this->parametersToArray($parameters);

        $response = $this->printfulClient->post('/mockup-generator/create-task/' . $parameters->productId, $data);

        return GenerationResultItem::fromArray($response);
    }

    /**
     * Create a tasks and waits for it to be complete by periodically checking for result.
     * If the timeout is exceeded, latest task result is returned which will be in pending state.
     *
     * @param MockupGenerationParameters $parameters
     * @param int $maxSecondsWait Maximum amount of seconds to wait for the result
     * @param int $interval Interval before requesting task result
     * @return GenerationResultItem Completed or failed generation result
     * @throws Exceptions\PrintfulException
     */
    public function createGenerationTaskAndWaitForResult(
        MockupGenerationParameters $parameters,
        $maxSecondsWait = 180,
        $interval = 5
    ) {
        $task = $this->createGenerationTask($parameters);

        for ($i = 0; $i < $maxSecondsWait / $interval; $i++) {
            sleep($interval);
            $task = $this->getGenerationTask($task->taskKey);
            if (!$task->isPending()) {
                break;
            }
        }

        return $task;
    }

    /**
     * Check for a generation task result
     *
     * @param string $tasKey
     * @return GenerationResultItem
     * @throws Exceptions\PrintfulException
     */
    public function getGenerationTask($tasKey)
    {
        $response = $this->printfulClient->get('/mockup-generator/task/', [
            'task_key' => $tasKey,
        ]);

        return GenerationResultItem::fromArray($response);
    }

    /**
     * @param MockupGenerationParameters $parameters
     * @return array
     */
    private function parametersToArray(MockupGenerationParameters $parameters)
    {
        $files = array_map(function (MockupGenerationFile $file) {
            $re = [
                'placement' => $file->placement,
                'image_url' => $file->imageUrl,
            ];

            if ($file->position) {
                $re['position'] = $file->position->toArray();
            }

            return $re;
        }, $parameters->getFiles());

        $data = [
            'variant_ids' => $parameters->variantIds,
            'files' => $files,
            'format' => $parameters->format,
            'option_groups' => $parameters->optionGroups,
            'product_options' => $parameters->productOptions,
            'options' => $parameters->options,
        ];

        return $data;
    }

    /**
     * Retrieve templates for given product. Resources returned may be used to create your own generator interface.
     * This includes background images and area positions.
     *
     * @param int $productId
     * @param string|null $orientation Used for wall art only {@see TemplateItem::ORIENTATION_HORIZONTAL} {@see TemplateItem::ORIENTATION_VERTICAL}
     * @return ProductTemplates
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function getProductTemplates($productId, $orientation = null)
    {
        $query = [];

        if ($orientation) {
            $query['orientation'] = $orientation;
        }

        $response = $this->printfulClient->get('/mockup-generator/templates/' . $productId, $query);

        $templates = new ProductTemplates;
        $templates->version = (int)$response['version'];
        $templates->minDpi = (int)$response['min_dpi'];

        $templates->variantMapping = array_map(function ($v) {
            return VariantTemplateMappingItem::fromArray($v);
        }, $response['variant_mapping']);

        $templates->templates = array_map(function ($v) {
            return TemplateItem::fromArray($v);
        }, $response['templates']);

        $templates->placementConflicts = array_map(function ($v) {
            $pc = new PlacementConflictItem;
            $pc->placement = $v['placement'];
            $pc->conflictingPlacements = $v['conflicts'];
            return $pc;
        }, $response['conflicting_placements']);

        return $templates;
    }
}
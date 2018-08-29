<?php


namespace Printful\Structures\Generator;

/**
 * Class holds all information to request mockup generation
 */
class MockupGenerationParameters
{
    const FORMAT_JPG = 'jpg';

    const FORMAT_PNG = 'png';

    /**
     * Printful product id
     * @var int
     */
    public $productId;

    /**
     * Products' Printful variant ids for which to generate mockups
     * @var array
     */
    public $variantIds = [];

    /**
     * @var MockupGenerationFile[]
     */
    private $files = [];

    /**
     * Desired format. PNG supports transparent background. JPG is faster.
     * @var string
     */
    public $format = self::FORMAT_JPG;

    /**
     * List of options to generate (Front, Back, etc)
     * If not provided, everything is generated.
     * @var string[]
     */
    public $options = [];

    /**
     * List of option groups to generate (for leggings Barefoot, High-heels, etc.)
     * If not provided, everything is generated.
     * @var string[]
     */
    public $optionGroups = [];

    /**
     * Key-value list of product options.
     * For example, ['stitch_color' => 'white'].
     * Depends on the product, available option list can be found here:
     * @see https://www.printful.com/docs/products#actionGet
     *
     * @var array
     */
    public $productOptions = [];


    /**
     * Add a file for a specific placement
     *
     * Available placements are defined in Placement class
     * @see \Printful\Structures\Placements
     *
     * @param string $placement
     * @param $imageUrl
     * @param MockupPositionItem|null $position Optional position for image for generation. If position is not provided, image will be fitted or stretched over the area.
     * @return self
     */
    public function addImageUrl($placement, $imageUrl, MockupPositionItem $position = null)
    {
        $file = new MockupGenerationFile;

        $file->placement = $placement;
        $file->imageUrl = $imageUrl;
        $file->position = $position;

        $this->files[] = $file;

        return $this;
    }

    /**
     * @return MockupGenerationFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}
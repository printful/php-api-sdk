<?php


namespace Printful\Structures\Generator;

/**
 * Class holds all information to request mockup generation
 */
class MockupGenerationParameters
{
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
     * Add a file for a specific placement
     *
     * Available placements are defined in Placement class
     * @see \Printful\Structures\Placements
     *
     * @param string $placement
     * @param $imageUrl
     * @return self
     */
    public function addImageUrl($placement, $imageUrl)
    {
        $file = new MockupGenerationFile;

        $file->placement = $placement;
        $file->imageUrl = $imageUrl;

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
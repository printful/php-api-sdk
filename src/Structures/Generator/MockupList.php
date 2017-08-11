<?php


namespace Printful\Structures\Generator;


/**
 * Class represents a a list of mockups for a specific product
 */
class MockupList
{
    /**
     * @var MockupItem[]
     */
    public $mockups = [];

    /**
     * Filter mockups for a given variant id
     *
     * @param int $variantId
     * @param string|null $placement Optional placement to filter mockups by
     * @return MockupItem[]
     */
    public function getVariantMockups($variantId, $placement = null)
    {
        return array_filter($this->mockups, function (MockupItem $mockup) use ($variantId, $placement) {
            if ($placement && $mockup->placement !== $placement) {
                return false;
            }
            return in_array($variantId, $mockup->variantIds);
        });
    }
}
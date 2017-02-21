<?php


namespace Printful\Tests\MockupGenerator;


use Printful\MockupGenerator;
use Printful\Structures\Generator\MockupGenerationParameters;
use Printful\Structures\Placements;
use Printful\Tests\TestCase;

class MockupGenerationTest extends TestCase
{
    /** @var MockupGenerator */
    private $generator;

    protected function setUp()
    {
        parent::setUp();
        $this->generator = new MockupGenerator($this->api);
    }

    public function testGeneratePosterMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 1; // Poster
        $parameters->variantIds = [
            1, // 18x24
            2, // 24x36
        ];

        $parameters->addImageUrl(Placements::TYPE_DEFAULT, 'https://dummyimage.com/600x400/000/fff');

        $result = $this->generator->generateMockups($parameters);

        self::assertEquals($parameters->productId, $parameters->productId, 'Product matches');
        self::assertCount(2, $result->mockups, 'Two mockups are generated');
        self::assertCount(1, $result->getVariantMockups(1), 'Variant 1 mockup exists');
        self::assertCount(1, $result->getVariantMockups(2), 'Variant 2 mockup exists');
    }

    public function testInvalidPlacement()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 1; // Poster
        $parameters->variantIds = [1]; // 18x24

        // Set invalid placement
        $parameters->addImageUrl(Placements::TYPE_FRONT, 'http://does-not-matter');

        self::expectExceptionMessage('File type "' . Placements::TYPE_FRONT . '" is not allowed for this product');

        $this->generator->generateMockups($parameters);
    }

    public function testGenerateShirtMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 71; // 3001 Unisex Short Sleeve Jersey T-Shirt with Tear Away Label
        $parameters->variantIds = [
            4011, // White S
            4012, // White M
            4013, // White L
            4016, // Black S
            4017, // Black M
            4018, // Black L
        ];

        $parameters->addImageUrl(Placements::TYPE_FRONT, 'https://dummyimage.com/600x400/000/fff');
        $parameters->addImageUrl(Placements::TYPE_BACK, 'https://dummyimage.com/600x400/000/fff');

        $result = $this->generator->generateMockups($parameters);

        self::assertEquals($parameters->productId, $result->productId, 'Product matches');
        self::assertCount(4, $result->mockups, '4 mockups are generated (2 colors x 2 placements');
        self::assertCount(2, $result->getVariantMockups(4011), 'One variant has 2 placements');

        self::assertCount(1, $result->getVariantMockups(4017, Placements::TYPE_FRONT),
            'Variant has mockup for front placement');

        self::assertCount(1, $result->getVariantMockups(4017, Placements::TYPE_BACK),
            'Variant has mockup for back placement');

        self::assertEmpty($result->getVariantMockups(4017, Placements::TYPE_DEFAULT),
            'Variant does not have a default placement mockup');
    }
}
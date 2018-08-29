<?php


namespace Printful\Tests\MockupGenerator;


use Printful\PrintfulMockupGenerator;
use Printful\Structures\Generator\MockupGenerationParameters;
use Printful\Structures\Generator\MockupPositionItem;
use Printful\Structures\Placements;
use Printful\Tests\TestCase;

class MockupGenerationTest extends TestCase
{
    /** @var PrintfulMockupGenerator */
    private $generator;

    protected function setUp()
    {
        parent::setUp();
        $this->generator = new PrintfulMockupGenerator($this->api);
    }

    public function testGeneratePostersWithPositions()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 1; // Poster
        $parameters->variantIds = [
            1, // 18x24
            2, // 24x36
        ];

        // Pre-set image positions that fill the whole area of mockup (same side ratio as poster size)
        $border = 40; // We will pad the image withing the area, so we can see a white border
        $position = new MockupPositionItem;
        $position->areaWidth = 720;
        $position->areaHeight = 960;
        $position->width = $position->areaWidth - $border * 2;
        $position->height = $position->areaHeight - $border * 2;
        $position->top = $border;
        $position->left = $border;

        // Image URL which is the same ratio as posters
        $imageUrl = $this->getDummyImageUrl(720, 960);

        $parameters->addImageUrl(Placements::TYPE_DEFAULT, $imageUrl, $position);

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        self::assertEquals($parameters->productId, $parameters->productId, 'Product matches');
        self::assertCount(2, $result->mockups, 'Two mockups are generated');
        self::assertCount(1, $result->getVariantMockups(1), 'Variant 1 mockup exists');
        self::assertCount(1, $result->getVariantMockups(2), 'Variant 2 mockup exists');
    }

    public function testGenerateSquarePosterWithoutPositions()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 1; // Poster
        $parameters->variantIds = [
            6239, // 10x10
        ];

        // No positions are given, so product image will be stretched over the poster (will cover whole area)
        $parameters->addImageUrl(Placements::TYPE_DEFAULT, $this->getDummyImageUrl(700, 700));

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters, 180, 1)->mockupList;

        self::assertCount(1, $result->mockups, 'One mockup is generated');
    }

    public function testInvalidPlacement()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 1; // Poster
        $parameters->variantIds = [1]; // 18x24

        // Set invalid placement
        $parameters->addImageUrl(Placements::TYPE_FRONT, 'http://does-not-matter');

        self::expectExceptionMessage('File type "' . Placements::TYPE_FRONT . '" is not allowed for this product');

        $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;
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

        // Positions for square image centered vertically, fits print file width
        $position = new MockupPositionItem;
        $position->areaWidth = 1800;
        $position->areaHeight = 2400;
        $position->width = 1800;
        $position->height = 1800;
        $position->top = 300;
        $position->left = 0;

        $dummyImage = $this->getDummyImageUrl(500, 500);

        $parameters->addImageUrl(Placements::TYPE_FRONT, $dummyImage, $position);
        $parameters->addImageUrl(Placements::TYPE_BACK, $dummyImage, $position);

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        self::assertCount(4, $result->mockups, '4 mockups are generated (2 colors x 2 placements');
        self::assertCount(2, $result->getVariantMockups(4011), 'One variant has 2 placements');

        self::assertCount(1, $result->getVariantMockups(4017, Placements::TYPE_FRONT),
            'Variant has mockup for front placement');

        self::assertCount(1, $result->getVariantMockups(4017, Placements::TYPE_BACK),
            'Variant has mockup for back placement');

        self::assertEmpty($result->getVariantMockups(4017, Placements::TYPE_DEFAULT),
            'Variant does not have a default placement mockup');
    }

    public function testGenerateHatMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 206; // Yupoong 6245CM - Unstructured Classic Dad Cap
        $parameters->variantIds = [
            7853, // White
        ];

        $parameters->productOptions = [
            'thread_colors' => [
                '#CC3333',
                '#A67843',
            ],
            'thread_colors_left' => [
                '#96A1A8',
                '#A67843',
            ],
        ];

        $parameters->addImageUrl(Placements::TYPE_EMBROIDERY_FRONT, $this->getDummyImageUrl(600, 400));
        $parameters->addImageUrl(Placements::TYPE_EMBROIDERY_LEFT, $this->getDummyImageUrl(600, 400));
        $parameters->addImageUrl(Placements::TYPE_EMBROIDERY_RIGHT, $this->getDummyImageUrl(600, 400));
        $parameters->addImageUrl(Placements::TYPE_EMBROIDERY_BACK, $this->getDummyImageUrl(600, 400));

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        self::assertCount(4, $result->mockups, '4 mockups are generated (one color front, back + 2 sides');
        self::assertCount(4, $result->getVariantMockups(7853), 'One variant has 4 placements');

        self::assertCount(1, $result->getVariantMockups(7853, Placements::TYPE_EMBROIDERY_FRONT),
            'Has front');

        self::assertCount(1, $result->getVariantMockups(7853, Placements::TYPE_EMBROIDERY_LEFT),
            'Has left');

        self::assertCount(1, $result->getVariantMockups(7853, Placements::TYPE_EMBROIDERY_RIGHT),
            'Has right');

        self::assertCount(1, $result->getVariantMockups(7853, Placements::TYPE_EMBROIDERY_BACK),
            'Has back');
    }

    public function testGenerateOnlyHighHeelBackLeggings()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 189; // Leggings
        $parameters->variantIds = [7679];  // L
        $parameters->options = ['Back'];
        $parameters->optionGroups = ['High-heels'];

        $parameters->addImageUrl(Placements::TYPE_DEFAULT, $this->getDummyImageUrl(600, 400));

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        self::assertCount(1, $result->getVariantMockups(7679), 'One variant mockup exists');
    }

    public function testGenerateMugWithExtraMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 19; // White Glossy Mug
        $parameters->variantIds = [1320];  // 11oz

        $position = new MockupPositionItem;
        $position->areaWidth = 520;
        $position->areaHeight = 202;
        $position->width = 70;
        $position->height = 70;
        $position->left = 225;
        $position->top = 66;

        $imageUrl = $this->getDummyImageUrl(700, 700);

        $parameters->addImageUrl(Placements::TYPE_DEFAULT, $imageUrl, $position);

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        $mockups = $result->getVariantMockups(1320);

        self::assertCount(1, $mockups, 'One mockup exists');
        self::assertCount(2, $mockups[0]->extraMockups, 'Two extra mockups exist');
    }

    public function testGenerateYogaLeggings()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 242; // White Glossy Mug
        $parameters->variantIds = [8356];  // 11oz

        $parameters->addImageUrl(Placements::TYPE_BELT_FRONT, 'https://dummyimage.com/1000x300/f00/fff');
        $parameters->addImageUrl(Placements::TYPE_BELT_BACK, 'https://dummyimage.com/1000x300/0f0/fff');
        $parameters->addImageUrl(Placements::TYPE_DEFAULT, 'https://dummyimage.com/1000x1000/00f/fff');

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        $mockups = $result->getVariantMockups(8356);

        self::assertCount(1, $mockups, 'One mockup exists');
        self::assertCount(3, $mockups[0]->extraMockups, 'Three extra mockups (back, left, right');
    }

    public function testGenerateCutSewShirt()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->format = $parameters::FORMAT_JPG;
        $parameters->productId = 257; // All-Over Cut & Sew Men's T-shirt
        $parameters->variantIds = [ // All variants: XS - 2XL
            8855,
            8853,
            8852,
            8851,
            8854,
            8850,
        ];

        $parameters->addImageUrl(Placements::TYPE_DEFAULT, 'https://dummyimage.com/600x400/f00/fff');
        $parameters->addImageUrl(Placements::TYPE_BACK, 'https://dummyimage.com/600x400/00f/fff');
        $parameters->addImageUrl(Placements::TYPE_SLEEVE_LEFT, 'https://dummyimage.com/600x400/0f0/fff');
        $parameters->addImageUrl(Placements::TYPE_SLEEVE_RIGHT, 'https://dummyimage.com/600x400/0f0/fff');

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        $mockups = $result->getVariantMockups(8855);

        self::assertCount(1, $mockups, 'One mockup exists');
        self::assertCount(3, $mockups[0]->extraMockups, 'Three extra mockups exist (back, left, right');
    }

    public function testGenerateSleeveMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 71; // 3001 Unisex Short Sleeve Jersey T-Shirt with Tear Away Label
        $parameters->variantIds = [
            4011, // White S
        ];

        $parameters->addImageUrl(Placements::TYPE_SLEEVE_LEFT, 'https://dummyimage.com/600x525/f00/fff');
        $parameters->addImageUrl(Placements::TYPE_SLEEVE_RIGHT, 'https://dummyimage.com/600x525/00f/fff');

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;

        self::assertCount(2, $result->mockups, '2 mockups with sleeves are generated');
        self::assertCount(2, $result->getVariantMockups(4011), 'One variant has 2 sleeve placements');

        self::assertCount(1, $result->getVariantMockups(4011, Placements::TYPE_SLEEVE_LEFT),
            'Variant has mockup for left sleeve placement');

        self::assertCount(1, $result->getVariantMockups(4011, Placements::TYPE_SLEEVE_RIGHT),
            'Variant has mockup for right sleeve placement');
    }

    public function testGenerateEmbroideryApparelMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 287; // 3800 Embroidered Polo Shirt
        $parameters->variantIds = [
            9114, // White S
        ];

        $parameters->productOptions = [
            'thread_colors_chest_left' => ['#FFCC00'],
        ];

        $parameters->addImageUrl(Placements::TYPE_EMBROIDERY_CHEST_LEFT, 'https://dummyimage.com/1200x1200/f00/fff');

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;
        $mockups = $result->getVariantMockups(9114);

        self::assertCount(1, $mockups, 'One on model mockup exists');
        self::assertCount(3, $mockups[0]->extraMockups, 'Two extra mockups exist (flat, wrinkled');
    }

    public function testGenerateBikiniMockups()
    {
        $parameters = new MockupGenerationParameters;
        $parameters->productId = 273; // Two-piece bikini
        $parameters->variantIds = [
            9021,
        ];

        $parameters->addImageUrl(Placements::TYPE_TOP, 'https://dummyimage.com/1200x1200/f00/fff');
        $parameters->addImageUrl(Placements::TYPE_FRONT, 'https://dummyimage.com/1200x1200/0f0/fff');
        $parameters->addImageUrl(Placements::TYPE_BACK, 'https://dummyimage.com/1200x1200/00f/fff');

        $result = $this->generator->createGenerationTaskAndWaitForResult($parameters)->mockupList;
        $mockups = $result->getVariantMockups(9021);

        self::assertCount(3, $mockups, 'Top, front, back mockups exist');
    }
}
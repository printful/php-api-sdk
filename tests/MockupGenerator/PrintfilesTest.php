<?php


namespace Printful\Tests\MockupGenerator;


use Printful\PrintfulMockupGenerator;
use Printful\Structures\Generator\PrintfileItem;
use Printful\Structures\Placements;
use Printful\Tests\TestCase;

class PrintfilesTest extends TestCase
{
    /**
     * @dataProvider productProvider
     * @param $productId
     * @param string|null $orientation
     * @throws \Printful\Exceptions\PrintfulException
     */
    public function testPrintfileRetrieval($productId, $orientation = null)
    {
        $generator = new PrintfulMockupGenerator($this->api);

        $productPrintfiles = $generator->getProductPrintfiles($productId, $orientation);

        self::assertEquals($productId, $productPrintfiles->productId);

        foreach (array_keys($productPrintfiles->availablePlacements) as $v) {
            self::assertTrue(
                Placements::isValid($v),
                'Given placement is valid'
            );
        }

        $variantPrintfile = reset($productPrintfiles->variantPrintfiles);
        $firstPrintfileId = reset($variantPrintfile->placements);

        self::assertTrue(
            array_key_exists($firstPrintfileId, $productPrintfiles->printfiles),
            'Variants printfile is defined within printfiles'
        );

        $printfile = reset($productPrintfiles->printfiles);
        self::assertTrue(in_array($printfile->fillMode, [
            PrintfileItem::FILL_MODE_COVER,
            PrintfileItem::FILL_MODE_FIT,
        ]), 'Printfile is within allowed');
    }

    public function productProvider()
    {
        return [
            [1],
            [1, 'vertical'], // Poster
            [1, 'horizontal'], // Poster
            [19], // 11oz mug
            [83], // Square Pillow Case w/ stuffing
        ];
    }
}
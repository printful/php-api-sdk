<?php


namespace Printful\Tests\MockupGenerator;


use Printful\Structures\Generator\PrintfileItem;
use Printful\Structures\Generator\ProductPrintfiles;
use Printful\Structures\Generator\VariantPrintfileItem;
use Printful\Structures\Placements;
use Printful\Tests\TestCase;

class PrintfileGroupingTest extends TestCase
{
    public function testOnePrintfileGrouping()
    {
        $pp = new ProductPrintfiles;

        $pp->availablePlacements = [
            Placements::TYPE_FRONT,
            Placements::TYPE_BACK,
        ];
        $pp->productId = 1;

        $pf = new PrintfileItem;
        $pf->printfileId = 777;

        $pp->printfiles[$pf->printfileId] = $pf;

        $vpi1 = new VariantPrintfileItem;
        $vpi1->variantId = 1;
        $vpi1->placements = [
            Placements::TYPE_FRONT => 777,
            Placements::TYPE_BACK => 777,
        ];

        $vpi2 = new VariantPrintfileItem;
        $vpi2->variantId = 2;
        $vpi2->placements = [
            Placements::TYPE_FRONT => 777,
            Placements::TYPE_BACK => 777,
        ];

        $vpi3 = new VariantPrintfileItem;
        $vpi3->variantId = 3;
        $vpi3->placements = [
            Placements::TYPE_FRONT => 777,
            Placements::TYPE_BACK => 777,
        ];

        $pp->variantPrintfiles = [
            $vpi1,
            $vpi2,
            $vpi3,
        ];

        $grouped = $this->generator()->groupPrintfiles($pp);

        foreach ($grouped as $v) {
            self::assertEquals([1, 2, 3], $v->variantIds);
            self::assertEquals($pf, $v->printfile);
            self::assertTrue(in_array($v->placement, [Placements::TYPE_FRONT, Placements::TYPE_BACK]));
        }
    }
}
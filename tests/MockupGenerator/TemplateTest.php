<?php


namespace Printful\Tests\MockupGenerator;


use Printful\PrintfulMockupGenerator;
use Printful\Structures\Generator\Templates\ProductTemplates;
use Printful\Tests\TestCase;

class TemplateTest extends TestCase
{
    public function testTemplateRetrieval()
    {
        $generator = new PrintfulMockupGenerator($this->api);

        $productId = 71; // Bella + Canvas 3001

        $templates = $generator->getProductTemplates($productId);

        self::assertInstanceOf(ProductTemplates::class, $templates);
        self::assertNotEmpty($templates->templates);
        self::assertNotEmpty($templates->variantMapping);
        self::assertGreaterThan(0, $templates->version);
        self::assertGreaterThan(0, $templates->minDpi);
        self::assertCount(2, $templates->placementConflicts, 'Two placement conflicts exist (outside label, back)');
    }
}
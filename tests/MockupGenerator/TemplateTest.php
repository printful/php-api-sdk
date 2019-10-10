<?php


namespace Printful\Tests\MockupGenerator;


use Printful\PrintfulMockupGenerator;
use Printful\Structures\Generator\Templates\ProductTemplates;
use Printful\Structures\Generator\Templates\TemplateItem;
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
        self::assertCount(3, $templates->placementConflicts, 'Two placement conflicts exist (outside label, inside label, back)');
    }

    public function testVerticalTemplateRetrieval()
    {
        $generator = new PrintfulMockupGenerator($this->api);
        $productId = 1; // Poster

        $templates = $generator->getProductTemplates($productId, TemplateItem::ORIENTATION_VERTICAL);

        foreach($templates->templates as $template){
            self::assertContains(
                $template->orientation,
                [TemplateItem::ORIENTATION_VERTICAL, TemplateItem::ORIENTATION_ANY],
                'Vertical or any orientation'
            );
        }
    }

    public function testHorizontalTemplateRetrieval()
    {
        $generator = new PrintfulMockupGenerator($this->api);
        $productId = 1; // Poster

        $templates = $generator->getProductTemplates($productId, TemplateItem::ORIENTATION_HORIZONTAL);

        foreach($templates->templates as $template){
            self::assertContains(
                $template->orientation,
                [TemplateItem::ORIENTATION_HORIZONTAL, TemplateItem::ORIENTATION_ANY],
                'Horizontal or any orientation'
            );
        }
    }
}
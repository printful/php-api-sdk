<?php


namespace Printful\Tests\MockupGenerator;


use Printful\PrintfulMockupGenerator;
use Printful\Tests\TestCase;

class TemplateTest extends TestCase
{
    public function testTemplateRetrieval()
    {
        $generator = new PrintfulMockupGenerator($this->api);

        $productId = 206;

        $productPrintfiles = $generator->getProductTemplates($productId);

        print_r($productPrintfiles);
    }
}
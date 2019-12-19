<?php

namespace Printful;

use Printful\Structures\Catalog\Product;
use Printful\Structures\TaxRateItem;

class PrintfulCatalog
{
    /**
     * @var PrintfulApiClient
     */
    private $printfulClient;

    /**
     * @param PrintfulApiClient $printfulClient
     */
    public function __construct(PrintfulApiClient $printfulClient)
    {
        $this->printfulClient = $printfulClient;
    }

    /**
     * Retrieve country list (with states)
     * @return Product[]
     */
    public function getProducts()
    {
        $raw = $this->printfulClient->get('products');
        $re = [];

        foreach ($raw as $v) {
            $country = Product::fromArray($v);

            $re[] = $country;
        }

        return $re;
    }
}

<?php

namespace Printful\Tests\Catalog;

use Printful\Structures\Catalog\Product;
use Printful\Structures\Catalog\ProductList;
use Printful\Structures\Catalog\ProductVariant;
use Printful\Structures\Catalog\ProductVariantList;

class GetRequestTest extends CatalogTestBase
{
	public function testProductListCanBeRetrieved()
	{
		$productList = $this->apiEndpoint->getList();
		self::assertInstanceOf(ProductList::class, $productList, 'Product List retrieved');
	}

	public function testProductsCanBeRetrieved()
	{
		$products = $this->apiEndpoint->getProducts();
		self::assertInstanceOf(Product::class, $products[0], 'Products retrieved');
	}

	public function testProductVariantCanBeRetrieved()
	{
		$productVariant = $this->apiEndpoint->getProductVariant();
		self::assertInstanceOf(ProductVariant::class, $productVariant, 'Product Variant retrieved');
	}

	public function testProductVariantListCanBeRetrieved()
	{
		$productVariantList = $this->apiEndpoint->getProductVariantList();
		self::assertInstanceOf(ProductVariantList::class, $productVariantList, 'Product Variant List retrieved');
	}
}
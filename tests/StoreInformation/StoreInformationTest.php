<?php

use Printful\PrintfulStoreInformation;
use Printful\Structures\Order\PackingSlipItem;
use Printful\Structures\Store\Store;
use Printful\Structures\Store\StoreCarriersServicesItem;
use Printful\Structures\Store\StoreStatistics;
use Printful\Tests\TestCase;

class StoreInformationTest extends TestCase
{
    /**
     * @var PrintfulStoreInformation
     */
    private $printfulStoreInformation;

    protected function setUp()
    {
        parent::setUp();
        $this->printfulStoreInformation = new PrintfulStoreInformation($this->api);
    }

    public function testStoreInformationCanBeRetrieved()
    {
        $store = $this->printfulStoreInformation->get();
        self::assertInstanceOf(Store::class, $store, 'Store information retrieved');
    }

    public function testStorePackingSlipCanBeUpdated()
    {
        $packingSlip = PackingSlipItem::fromArray([
            'email' => 'test@example.com',
            'phone' => '(111) 222-3333',
            'message' => 'Message text',
        ]);

        $updatedPackingSlip = $this->printfulStoreInformation->postPackingSlip($packingSlip);
        self::assertEquals($packingSlip->email,  $updatedPackingSlip->email, 'Packing slip updated');
    }

    public function testStoreStaticticsCanBeRetrieved()
    {
        $statistics = $this->printfulStoreInformation->getStoreStatistics();
        self::assertInstanceOf(StoreStatistics::class, $statistics, 'Store statistics retrieved');
    }

    public function testStoreCarriersServicesCanBeRetrieved()
    {
        $carrierList = $this->printfulStoreInformation->getCarriersServices();
        self::assertInstanceOf(StoreCarriersServicesItem::class, $carrierList->carriers[0],'Carriers can be retrieved');
    }

    public function testStoreCarriersServicesCanBeUpdated()
    {
        $testParams = $this->getTestCarrierParams();
        $carrierList = $this->printfulStoreInformation->postCarriersServiceStatus($testParams);
        self::assertInstanceOf(StoreCarriersServicesItem::class, $carrierList->carriers[0],'Carriers can be updated');
    }

    private function getTestCarrierParams()
    {
        $carriers = [
            [
                'id' => 'STANDARD',
                'status' => 'on',
            ]
        ];

        return $carriers;
    }

}
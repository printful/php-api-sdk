<?php

use Printful\PrintfulStoreInformation;
use Printful\Structures\Order\PackingSlipItem;
use Printful\Structures\Store\Store;
use Printful\Structures\Store\StoreCarriersServicesItem;
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
            'email' => 'test' . rand(0, 99) . '@example.com',
            'phone' => '(111) 222-33' . rand(10, 99),
            'message' => 'Message text ' . rand(0, 99),
        ]);

        $updatedPackingSlip = $this->printfulStoreInformation->setPackingSlip($packingSlip);
        self::assertEquals($packingSlip->email,  $updatedPackingSlip->email, 'Packing slip email updated');
        self::assertEquals($packingSlip->phone,  $updatedPackingSlip->phone, 'Packing slip phone updated');
        self::assertEquals($packingSlip->message,  $updatedPackingSlip->message, 'Packing slip message updated');
    }

    public function testStoreCarriersServicesCanBeRetrieved()
    {
        $carrierList = $this->printfulStoreInformation->getCarriersServices();
        self::assertInstanceOf(StoreCarriersServicesItem::class, $carrierList->carriers[0],'Carriers can be retrieved');
    }

    public function testStoreCarriersServicesCanBeUpdated()
    {
        $testParamsEnable = $this->getTestCarrierEnableParams();
        $carrierList = $this->printfulStoreInformation->setCarriersServiceStatus($testParamsEnable);
        $carrier = $this->getCarrierWithId($carrierList, $testParamsEnable[0]['carrier_id']);
        self::assertEquals($carrier->status, $testParamsEnable[0]['status'],'Carriers can be enabled');

        $testParamsDisable = $this->getTestCarrierDisableParams();
        $carrierList = $this->printfulStoreInformation->setCarriersServiceStatus($testParamsDisable);
        $carrier = $this->getCarrierWithId($carrierList, $testParamsDisable[0]['carrier_id']);
        self::assertEquals($carrier->status, $testParamsDisable[0]['status'],'Carriers can be disabled');
    }

    private function getTestCarrierEnableParams()
    {
        $carriers = [
            [
                'carrier_id' => 'STANDARD',
                'status' => 'on',
            ]
        ];

        return $carriers;
    }

    private function getTestCarrierDisableParams()
    {
        $carriers = [
            [
                'carrier_id' => 'STANDARD',
                'status' => 'off',
            ]
        ];

        return $carriers;
    }

    private function getCarrierWithId($carrierList, $carrierId)
    {
        $carrier = null;

        foreach ($carrierList->carriers as $carrierListItem) {
            if ($carrierListItem->carrierId == $carrierId) {
                $carrier = $carrierListItem;
                break;
            }
        }

        return $carrier;
    }

}
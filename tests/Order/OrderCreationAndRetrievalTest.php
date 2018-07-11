<?php


use Printful\PrintfulOrder;
use Printful\Structures\Order\Order;
use Printful\Structures\Order\OrderCostGroup;
use Printful\Structures\Order\OrderCostsItem;
use Printful\Structures\Order\OrderCreationParameters;
use Printful\Structures\Order\OrderItemCreationParameters;
use Printful\Structures\Order\OrderItemFile;
use Printful\Structures\Order\OrderList;
use Printful\Structures\Order\RecipientCreationParameters;
use Printful\Tests\TestCase;

class OrderCreationAndRetrievalTest extends TestCase
{
    /**
     * @var PrintfulOrder
     */
    private $printfulOrder;

    protected function setUp()
    {
        parent::setUp();
        $this->printfulOrder = new PrintfulOrder($this->api);
    }

    public function testOrderCanBeCreated()
    {
        $externalId = uniqid();
        $params = $this->getTestOrderParams();
        $params->externalId = $externalId;

        $order = $this->printfulOrder->create($params);
        self::assertEquals($externalId, $order->externalId, 'Order with specified external ID was created');
    }

    public function testOrderCanBeCanceled()
    {
        $externalId = uniqid();
        $params = $this->getTestOrderParams();
        $params->externalId = $externalId;

        $order = $this->printfulOrder->create($params);
        $canceledOrder = $this->printfulOrder->cancel($order->id);
        self::assertEquals(
            Order::STATUS_CANCELED,
            $canceledOrder->status,
            'After cancellation order has status ' . Order::STATUS_CANCELED
        );
    }

    public function testOrderCanBeUpdated()
    {
        $externalId = uniqid();
        $params = $this->getTestOrderParams();
        $params->externalId = $externalId;

        $order = $this->printfulOrder->create($params);

        // Add another item to order
        $itemParams = new OrderItemCreationParameters;
        $itemParams->variantId = 8004;
        $itemParams->quantity = 1;
        $itemParams->retailPrice = 23.99;
        $itemParams->addFile(
            OrderItemFile::TYPE_DEFAULT,
            'https://pbs.twimg.com/profile_images/1044686525/Get_Some.jpg'
        );
        $params->addItem($itemParams);


        $updatedOrder = $this->printfulOrder->update($params, $order->id, true);
        self::assertEquals(2, count($updatedOrder->items), 'Another item was added to order after update');
    }

    public function testOrderCanBeRetrievedByPrintfulAndExternalId()
    {
        $externalId = uniqid();
        $params = $this->getTestOrderParams();
        $params->externalId = $externalId;

        $order = $this->printfulOrder->create($params);

        // Retrieve order by Printful ID
        $printfulId = $order->id;
        $retrievedOrder = $this->printfulOrder->getByPrintfulId($printfulId);
        self::assertEquals($printfulId, $retrievedOrder->id, 'Order can be retrieved by Printful ID');

        // Retrieve order by External ID. ID is prefixed with @ symbol to trigger possible error
        $retrievedOrder = $this->printfulOrder->getByExternalId('@' . $externalId);
        self::assertEquals($externalId, $retrievedOrder->externalId, 'Order can be retrieved by external ID');
    }

    public function testOrderListCanBeRetrieved()
    {
        $orderList = $this->printfulOrder->getList();
        self::assertInstanceOf(OrderList::class, $orderList, 'Order List retrieved');
    }

    public function testOrderCostsCanBeEstimated()
    {
        $externalId = uniqid();
        $params = $this->getTestOrderParams();
        $params->externalId = $externalId;

        $estimate = $this->printfulOrder->estimateCosts($params);

        self::assertInstanceOf(OrderCostGroup::class, $estimate, 'Costs estimate retrieved');
        self::assertInstanceOf(OrderCostsItem::class, $estimate->printfulCosts, 'Cost estimate correct type');
    }

    /**
     * @return OrderCreationParameters
     */
    private function getTestOrderParams()
    {
        $params = new OrderCreationParameters;
        $params->shipping = 'STANDARD';

        $params->addPackingSlip('test@example.com', '111-222-3333', 'Message text');
        $params->addGift('New Gift', 'Gift message');
        $params->addRetailCosts(5.01, 4.01, 2.01);

        $recipientParams = new RecipientCreationParameters;
        $recipientParams->address1 = '98 NW. State Street';
        $recipientParams->address2 = 'Floor1';
        $recipientParams->countryCode = 'US';
        $recipientParams->stateCode = 'MN';
        $recipientParams->city = 'Shakopee';
        $recipientParams->zip = '55379';
        $params->addRecipient($recipientParams);

        $itemParams = new OrderItemCreationParameters;
        $itemParams->externalId = '1ax';
        $itemParams->variantId = 256;
        $itemParams->quantity = rand(1, 3);
        $itemParams->retailPrice = 20.00;
        $itemParams->name = 'Some item name';
        $itemParams->sku = '00000000';
        $itemParams->addFile(
            OrderItemFile::TYPE_DEFAULT,
            'https://placeholdit.imgix.net/~text?txtsize=200&txt=2400%C3%972400&w=2400&h=2400'
        );
        $params->addItem($itemParams);

        return $params;
    }
}
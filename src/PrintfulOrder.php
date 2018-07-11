<?php

namespace Printful;

use Printful\Structures\Order\Order;
use Printful\Structures\Order\OrderCostGroup;
use Printful\Structures\Order\OrderCreationParameters;
use Printful\Structures\Order\OrderItemCreationParameters;
use Printful\Structures\Order\OrderList;

class PrintfulOrder
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
     * @param OrderCreationParameters $parameters
     * @param bool $confirm - Automatically submit the newly created order for fulfillment (skip the Draft phase)
     * @return Order
     */
    public function create(OrderCreationParameters $parameters, $confirm = false)
    {
        $request = $this->getRequestBodyFromParams($parameters);
        $params['confirm'] = $confirm;

        $raw = $this->printfulClient->post('orders', $request, $params);

        return Order::fromArray($raw);
    }

    /**
     * Updates unsubmitted order and optionally submits it for the fulfillment.
     * Post only the fields that need to be changed, not all required fields.
     *
     * @param OrderCreationParameters $parameters
     * @param string|int $orderId - Order ID (integer) or External ID (prefixed with @)
     * @param bool $confirm - Automatically submit the newly created order for fulfillment (skip the Draft phase)
     * @return Order
     */
    public function update(OrderCreationParameters $parameters, $orderId, $confirm = false)
    {
        $request = $this->getRequestBodyFromParams($parameters);
        $params['confirm'] = $confirm;

        $raw = $this->printfulClient->put('orders/' . $orderId, $request, $params);
        return Order::fromArray($raw);
    }

    /**
     * Sets the order status to CANCELED
     * @param string|int $orderId - Order ID (integer) or External ID (prefixed with @)
     * @return Order
     */
    public function cancel($orderId)
    {
        $raw = $this->printfulClient->delete('orders/' . $orderId);
        return Order::fromArray($raw);
    }

    /**
     * Approves for fulfillment an order that was saved as a draft
     * @param string|int $orderId - Order ID (integer) or External ID (prefixed with @)
     * @return Order
     */
    public function confirm($orderId)
    {
        $raw = $this->printfulClient->post('orders/' . $orderId . '/confirm');
        return Order::fromArray($raw);
    }

    /**
     * @param string|int $orderId - Order ID (integer) or External ID (prefixed with @)
     * @return Order
     */
    private function getById($orderId)
    {
        $raw = $this->printfulClient->get('orders/' . $orderId);
        return Order::fromArray($raw);
    }

    /**
     * @param int $printfulId
     * @return Order
     */
    public function getByPrintfulId($printfulId)
    {
        return $this->getById($printfulId);
    }

    /**
     * @param string $externalId
     * @return Order
     */
    public function getByExternalId($externalId)
    {
        // Always remove possible @ symbol given by caller
        $id = '@' . ltrim($externalId, '@');
        return $this->getById($id);
    }

    /**
     * @param int $offset
     * @param int $limit - Number of items per page (max 100)
     * @param null|string $status - Filter by order status
     * @return OrderList
     */
    public function getList($offset = 0, $limit = 10, $status = null)
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit,
            'status' => $status,
        ];
        $rawOrders = $this->printfulClient->get('orders', $params);
        $total = $this->printfulClient->getItemCount();

        return new OrderList($rawOrders, $total, $offset);
    }

    /**
     * @param OrderCreationParameters $parameters
     * @return OrderCostGroup
     * @throws Exceptions\PrintfulApiException
     * @throws Exceptions\PrintfulException
     */
    public function estimateCosts(OrderCreationParameters $parameters)
    {
        $request = $this->getRequestBodyFromParams($parameters);

        $raw = $this->printfulClient->post('orders/estimate-costs', $request);

        return OrderCostGroup::fromArray($raw);
    }

    /**
     * Formats request body array from order creation parameters object
     *
     * @param OrderCreationParameters $parameters
     * @return array
     */
    protected function getRequestBodyFromParams(OrderCreationParameters $parameters)
    {
        $request = [
            'external_id' => $parameters->externalId,
            'shipping' => $parameters->shipping,
            'recipient' => $parameters->getRecipient()->toArray(),
            'retail_costs' => $parameters->getRetailCosts(),
            'gift' => $parameters->getGift(),
            'packing_slip' => $parameters->getPackingSlip(),
            'currency' => $parameters->currency,
        ];

        // Set order Items from given array of param objects
        $request['items'] = array_map(function (OrderItemCreationParameters $params) {
            return $params->toArray();
        }, $parameters->getItems());

        return $request;
    }
}

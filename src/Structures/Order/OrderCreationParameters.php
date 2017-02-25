<?php

namespace Printful\Structures\Order;

class OrderCreationParameters
{

    /**
     * @var string
     */
    public $externalId;

    /**
     * @var string - Shipping method. Defaults to 'STANDARD'
     */
    public $shipping;

    /**
     * @var RecipientCreationParameters
     */
    private $recipient;

    /**
     * @var OrderCreationParameters[]
     */
    private $items = [];

    /**
     * @var array
     */
    private $retailCosts;

    /**
     * @var array
     */
    private $gift;

    /**
     * @var array
     */
    private $packingSlip;

    /**
     * @var string - 3 letter currency code (optional)
     * Required if the retail costs should be convert from another currency instead of USD
     */
    public $currency = 'USD';


    /**
     * Shipping address
     *
     * @param RecipientCreationParameters $parameters
     */
    public function addRecipient(RecipientCreationParameters $parameters)
    {
        $this->recipient = $parameters;
    }

    /**
     * @param OrderItemCreationParameters $parameters
     */
    public function addItem(OrderItemCreationParameters $parameters)
    {
        $this->items[] = $parameters;
    }

    /**
     * Original retail costs in USD that are to be displayed on the packing slip for international shipments.
     * Retail costs are used only if every item in order contains the retail_price attribute.
     *
     * @param float $discount
     * @param float $shipping
     * @param float $tax
     */
    public function addRetailCosts($discount, $shipping, $tax)
    {
        $this->retailCosts = [
            'discount' => $discount,
            'shipping' => $shipping,
            'tax' => $tax,
        ];
    }

    /**
     * Add gift message
     *
     * @param string $subject
     * @param string $message
     */
    public function addGift($subject, $message)
    {
        $this->gift = [
            'subject' => $subject,
            'message' => $message,
        ];
    }

    /**
     * Add custom packing slip for this order
     *
     * @param string $email
     * @param string $phone
     * @param string $message
     */
    public function addPackingSlip($email, $phone, $message)
    {
        $this->packingSlip = [
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
        ];
    }

    /**
     * @return RecipientCreationParameters
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return OrderCreationParameters[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getRetailCosts()
    {
        return $this->retailCosts;
    }

    /**
     * @return array
     */
    public function getGift()
    {
        return $this->gift;
    }

    /**
     * @return array
     */
    public function getPackingSlip()
    {
        return $this->packingSlip;
    }
}

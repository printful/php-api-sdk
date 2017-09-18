<?php

namespace Printful\Structures\Store;

use Printful\Structures\AddressItem;
use Printful\Structures\BaseItem;
use Printful\Structures\Order\PackingSlipItem;

class Store extends BaseItem
{
    /**
     * Store ID
     * @var int
     */
    public $id;

    /**
     * Store name
     * @var String
     */
    public $name;

    /**
     * Store website URL
     * @var String
     */
    public $website;

    /**
     * Custom return address (if enabled)
     * @var AddressItem
     */
    public $returnAddress;

    /**
     * Default billing address (if configured)
     * @var AddressItem
     */
    public $billingAddress;

    /**
     * Default payment card (if configured)
     * @var
     */
    public $paymentCard;

    /**
     * Packing slip information of the current store
     * @var PackingSlipItem
     */
    public $packingSlip;

    /**
     * Store creation timestamp
     * @var int - Timestamp
     */
    public $created;

    /**
     * @param array $raw
     * @return Store
     */
    public static function fromArray(array $raw)
    {
        $store = new self;
        $store->id = (int)$raw['id'];
        $store->name = $raw['name'];
        $store->website = $raw['website'];
        $store->returnAddress = isset($raw['return_address']) ? AddressItem::fromArray($raw['return_address']) : null;
        $store->billingAddress = isset($raw['billing_address']) ? AddressItem::fromArray($raw['billing_address']) : null;
        $store->paymentCard = $raw['payment_card'];
        $store->packingSlip = isset($raw['packing_slip']) ? PackingSlipItem::fromArray($raw['packing_slip']) : null;
        $store->created = (int)$raw['created'];

        return $store;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'website' => $this->website,
            'return_address' => $this->returnAddress,
            'billing_address' => $this->billingAddress,
            'payment_card' => $this->paymentCard,
            'packing_slip' => $this->packingSlip->toArray(),
            'created' => $this->created,
        ];
    }
}
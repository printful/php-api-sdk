<?php

namespace Printful\Structures\Store;

use Printful\Structures\AddressItem;
use Printful\Structures\BaseItem;
use Printful\Structures\Order\PackingSlipItem;

class Store extends BaseItem
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var String
     */
    public $name;

    /**
     * @var String
     */
    public $website;

    /**
     * @var AddressItem
     */
    public $return_address;

    /**
     * @var AddressItem
     */
    public $billing_address;

    /**
     * @var
     */
    public $payment_card;

    /**
     * @var PackingSlipItem
     */
    public $packing_slip;

    /**
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
        $store->return_address = isset($raw['return_address']) ? AddressItem::fromArray($raw['return_address']) : null;
        $store->billing_address = isset($raw['billing_address']) ? AddressItem::fromArray($raw['billing_address']) : null;
        $store->payment_card = $raw['payment_card'];
        $store->packing_slip = isset($raw['packing_slip']) ? PackingSlipItem::fromArray($raw['packing_slip']) : null;
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
            'return_address' => $this->return_address,
            'billing_address' => $this->billing_address,
            'payment_card' => $this->payment_card,
            'packing_slip' => $this->packing_slip->toArray(),
            'created' => $this->created,
        ];
    }
}
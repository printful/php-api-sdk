<?php

namespace Printful\Structures\Store;

use Printful\Structures\BaseItem;

class StoreCarriersServicesList extends BaseItem
{

    /**
     * @var array
     */
    public $carriers;

    /**
     * @param array $raw
     * @return StoreCarriersServicesList
     */
    public static function fromArray(array $raw)
    {
        $carrierList = new self;
        foreach ($raw as $v) {
            $carrierList->carriers[] = StoreCarriersServicesItem::fromArray($v);
        }
        return $carrierList;
    }
}
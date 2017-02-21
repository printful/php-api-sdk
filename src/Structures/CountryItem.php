<?php

namespace Printful\Structures;

class CountryItem extends BaseItem
{
    /**
     * @var string
     * ISO country code
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $states = [];


    /**
     * @param array $raw
     * @return CountryItem
     */
    public static function fromArray(array $raw)
    {
        $country = new CountryItem;

        $country->code = $raw['code'];
        $country->name = $raw['name'];

        return $country;
    }
}

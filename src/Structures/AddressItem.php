<?php

namespace Printful\Structures;


class AddressItem extends BaseItem
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $address1;

    /**
     * @var string|null
     */
    public $address2;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $stateCode;

    /**
     * @var string
     */
    public $stateName;

    /**
     * @var string
     */
    public $countryCode;

    /**
     * @var string
     */
    public $countryName;

    /**
     * @var string
     */
    public $zip;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;

    /**
     * @param array $raw
     * @return AddressItem
     */
    public static function fromArray(array $raw)
    {
        $address = new self;

        $address->name = isset($raw['name']) ? $raw['name'] : null;
        $address->company = isset($raw['company']) ? $raw['company'] : null;
        $address->address1 = $raw['address1'];
        $address->address2 = isset($raw['address2']) ? $raw['address2'] : null;
        $address->city = $raw['city'];
        $address->stateCode = isset($raw['state_code']) ? $raw['state_code'] : null;
        $address->stateName = isset($raw['state_name']) ? $raw['state_name'] : null;
        $address->countryCode = $raw['country_code'];
        $address->countryName = isset($raw['country_name']) ? $raw['country_name'] : null;
        $address->zip = $raw['zip'];
        $address->phone = isset($raw['phone']) ? $raw['phone'] : null;
        $address->email = isset($raw['email']) ? $raw['email'] : null;

        return $address;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'company' => $this->company,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'stateCode' => $this->stateCode,
            'countryCode' => $this->countryCode,
            'countryName' => $this->countryName,
            'zip' => $this->zip,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
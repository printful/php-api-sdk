<?php

namespace Printful\Structures\Order;

class RecipientCreationParameters
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
            'state_code' => $this->stateCode,
            'state_name' => $this->stateName,
            'country_code' => $this->countryCode,
            'country_name' => $this->countryName,
            'zip' => $this->zip,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}

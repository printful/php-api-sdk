<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class PackingSlipItem extends BaseItem
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $message;

    /**
     * @param array $raw
     * @return PackingSlipItem
     */
    public static function fromArray(array $raw)
    {
        $slip = new self;

        $slip->email = $raw['email'];
        $slip->phone = $raw['phone'];
        $slip->message = $raw['message'];

        return $slip;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ];
    }

}
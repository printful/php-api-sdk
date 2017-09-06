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

        $slip->email = isset($raw['email']) ? $raw['email'] : '';
        $slip->phone = isset($raw['phone']) ? $raw['phone'] : '';
        $slip->message = isset($raw['message']) ? $raw['message'] : '';

        return $slip;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'email' => isset($this->email) ? $this->email : '',
            'phone' => isset($this->phone) ? $this->phone : '',
            'message' => isset($this->message) ? $this->message : '',
        ];
    }

}
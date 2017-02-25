<?php

namespace Printful\Structures\Order;


use Printful\Structures\BaseItem;

class GiftItem extends BaseItem
{
    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $message;

    /**
     * @param array $raw
     * @return GiftItem
     */
    public static function fromArray(array $raw)
    {
        $gift = new self;

        $gift->subject = $raw['subject'];
        $gift->message = $raw['message'];

        return $gift;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
        ];
    }

}
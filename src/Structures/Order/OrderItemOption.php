<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class OrderItemOption extends BaseItem
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @param array $raw
     * @return OrderItemOption
     */
    public static function fromArray(array $raw)
    {
        $option = new self;

        $option->id = $raw['id'];
        $option->value = $raw['value'];

        return $option;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}

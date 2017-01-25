<?php
namespace Printful\Structures;

class StateItem extends BaseItem
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @param array $raw
     * @return StateItem
     */
    public static function fromArray(array $raw)
    {
        $item = new StateItem;

        $item->code = $raw['code'];
        $item->name = $raw['name'];

        return $item;
    }
}

<?php


namespace Printful\Structures\Generator\Templates;


use Printful\Structures\BaseItem;

class VariantTemplateMappingItem extends BaseItem
{
    /**
     * Printful product variant id
     * @var int
     */
    public $variantId;

    /**
     * Placements mapped by template ids.
     * Use this list to find out which templates have to be used for this product variant
     *
     * @var array [placement => templateId, ..]
     */
    public $templates = [];

    /**
     * @param array $raw
     * @return VariantTemplateMappingItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;
        $item->variantId = (int)$raw['variant_id'];

        foreach ($raw['templates'] as $v) {
            $item->templates[$v['placement']] = (int)$v['template_id'];
        }

        return $item;
    }
}
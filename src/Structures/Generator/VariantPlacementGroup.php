<?php


namespace Printful\Structures\Generator;

/**
 * Class represents a a group of variants that have the same placement and printfile
 */
class VariantPlacementGroup
{
    /**
     * Placement identifier Placements::TYPE_*
     * @var string
     */
    public $placement;

    /**
     * @var PrintfileItem
     */
    public $printfile;

    /**
     * List of variant ids that are covered by this placement group
     * @var int[]
     */
    public $variantIds = [];
}
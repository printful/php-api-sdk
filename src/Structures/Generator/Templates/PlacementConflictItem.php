<?php


namespace Printful\Structures\Generator\Templates;


/**
 * @see \Printful\Structures\Placements
 */
class PlacementConflictItem
{
    /**
     * Placement id
     * @var string
     * @see \Printful\Structures\Placements::$types
     */
    public $placement;

    /**
     * List of placement ids that are in conflict (cannot be used at the same time)
     * @var string[]
     */
    public $conflictingPlacements;
}
<?php


namespace Printful\Structures\Generator\Templates;


/**
 * Class represents a list of templates (not to confuse with printfiles)
 */
class ProductTemplates
{
    /**
     * Indicates the version of resources.
     * If this changes, resources should be re-cached.
     * @var int
     */
    public $version;

    /**
     * Minimum DPI that is recommended for the user image
     * @var int
     */
    public $minDpi;

    /**
     * Product variants mapped to templates
     * @var VariantTemplateMappingItem[]
     */
    public $variantMapping = [];

    /**
     * List of templates available. Use $variantMapping to link variants to templates.
     * @var TemplateItem[]
     */
    public $templates = [];

    /**
     * List of placement conflicts. This helps to determine which placements conflict (cannot be used together with).
     *
     * @var PlacementConflictItem[]
     */
    public $placementConflicts;
}
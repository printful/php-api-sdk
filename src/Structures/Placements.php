<?php


namespace Printful\Structures;


class Placements
{
    /**
     * Default placement (for posters, mugs, etc.)
     */
    const TYPE_DEFAULT = 'default';

    /**
     * Front placement for embroidery
     */
    const TYPE_EMBROIDERY_FRONT = 'embroidery_front';

    /**
     * Embroidery left side
     */
    const TYPE_EMBROIDERY_LEFT = 'embroidery_left';

    /**
     * Embroidery right side
     */
    const TYPE_EMBROIDERY_RIGHT = 'embroidery_right';

    /**
     * Back placement for embroidery
     */
    const TYPE_EMBROIDERY_BACK = 'embroidery_back';

    /**
     * Left chest placement for apparel embroidery
     */
    const TYPE_EMBROIDERY_CHEST_LEFT = 'embroidery_chest_left';

    /**
     * Front placement for apparel embroidery
     */
    const TYPE_EMBROIDERY_APPAREL_FRONT = 'embroidery_apparel_front';

    /**
     * Front for DTG products, double-sided totes, etc
     */
    const TYPE_FRONT = 'front';

    /**
     * Back for DTG products, double-sided totes, etc
     */
    const TYPE_BACK = 'back';

    /**
     * Inside label, for DTG products, except totes
     */
    const TYPE_LABEL_INSIDE = 'label_inside';

    /**
     * Outside label, for DTG products, except totes
     */
    const TYPE_LABEL_OUTSIDE = 'label_outside';

    /**
     * Belt front (leggings)
     */
    const TYPE_BELT_FRONT = 'belt_front';

    /**
     * Belt back (leggings)
     */
    const TYPE_BELT_BACK = 'belt_back';

    /**
     * Left sleeve (Cut & Sew, DTG shirts)
     */
    const TYPE_SLEEVE_LEFT = 'sleeve_left';

    /**
     * Right sleeve (Cut & Sew, DTG shirts)
     */
    const TYPE_SLEEVE_RIGHT = 'sleeve_right';

    /**
     * Mockup of the product, can be used when submitting orders, etc
     */
    const TYPE_MOCKUP = 'mockup';

    /**
     * Bikini top, backpack etc.
     */
    const TYPE_TOP = 'top';

    /**
     * @var array
     */
    public static $types = [
        self::TYPE_DEFAULT => [
            'title' => 'Print file',
            'conflictingTypes' => [],
        ],
        self::TYPE_FRONT => [
            'title' => 'Front print',
            'conflictingTypes' => [],
        ],
        self::TYPE_BACK => [
            'title' => 'Back print',
            'conflictingTypes' => [self::TYPE_LABEL_OUTSIDE],
        ],
        self::TYPE_EMBROIDERY_FRONT => [
            'title' => 'Front',
            'conflictingTypes' => [],
        ],
        self::TYPE_EMBROIDERY_LEFT => [
            'title' => 'Left side',
            'conflictingTypes' => [],
        ],
        self::TYPE_EMBROIDERY_RIGHT => [
            'title' => 'Right side',
            'conflictingTypes' => [],
        ],
        self::TYPE_EMBROIDERY_BACK => [
            'title' => 'Back',
            'conflictingTypes' => [],
        ],
        self::TYPE_EMBROIDERY_CHEST_LEFT => [
            'title' => 'Left chest',
            'conflictingTypes' => [],
        ],
        self::TYPE_EMBROIDERY_APPAREL_FRONT => [
            'title' => 'Front',
            'conflictingTypes' => [],
        ],
        self::TYPE_LABEL_INSIDE => [
            'title' => 'Inside label',
            'conflictingTypes' => [self::TYPE_LABEL_OUTSIDE],
        ],
        self::TYPE_LABEL_OUTSIDE => [
            'title' => 'Outside label',
            'conflictingTypes' => [self::TYPE_BACK, self::TYPE_LABEL_INSIDE],
        ],
        self::TYPE_SLEEVE_LEFT => [
            'title' => 'Left Sleeve',
            'conflictingTypes' => [],
        ],
        self::TYPE_SLEEVE_RIGHT => [
            'title' => 'Right Sleeve',
            'conflictingTypes' => [],
        ],
        self::TYPE_BELT_FRONT => [
            'title' => 'Front waist',
            'conflictingTypes' => [],
        ],
        self::TYPE_BELT_BACK => [
            'title' => 'Back waist',
            'conflictingTypes' => [],
        ],
        self::TYPE_TOP => [
            'title' => 'Top',
            'conflictingTypes' => [],
        ],
    ];

    /**
     * Check whether placement is valid
     *
     * @param string $placement
     * @return bool
     */
    public static function isValid($placement)
    {
        return isset(self::$types[$placement]);
    }
}
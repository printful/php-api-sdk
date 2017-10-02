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
     * Mockup of the product, can be used when submitting orders, etc
     */
    const TYPE_MOCKUP = 'mockup';

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
        self::TYPE_LABEL_INSIDE => [
            'title' => 'Inside label',
            'conflictingTypes' => [self::TYPE_LABEL_OUTSIDE],
        ],
        self::TYPE_LABEL_OUTSIDE => [
            'title' => 'Outside label',
            'conflictingTypes' => [self::TYPE_BACK, self::TYPE_LABEL_INSIDE],
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
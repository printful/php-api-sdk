<?php


namespace Printful\Structures\Generator;

use Printful\Exceptions\PrintfulException;

class MockupPositionItem
{
    /**
     * Positioning area width in pixels
     * @var int
     */
    public $areaWidth;

    /**
     * Positioning area height in pixels
     * @var int
     */
    public $areaHeight;

    /**
     * Image width within the area in pixels
     * @var int
     */
    public $width;

    /**
     * Image height within the area in pixels
     * @var int
     */
    public $height;

    /**
     * Image top offset from positioning area
     * @var int
     */
    public $top;

    /**
     * Image left offset from positioning area
     * @var int
     */
    public $left;

    /**
     * @return array
     * @throws PrintfulException
     */
    public function toArray()
    {
        if ($this->width <= 0 || $this->height <= 0) {
            throw new PrintfulException('Invalid size given for position item (less or equals zero)');
        }

        return [
            'area_width' => (int)$this->areaWidth,
            'area_height' => (int)$this->areaHeight,
            'width' => (int)$this->width,
            'height' => (int)$this->height,
            'top' => (int)$this->top,
            'left' => (int)$this->left,
        ];
    }
}
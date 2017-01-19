<?php


namespace Printful\Structures\Generator;


use Printful\Structures\BaseItem;

class PrintfileItem extends BaseItem
{
    /**
     * File should be fitted in the given area
     */
    const FILL_MODE_FIT = 'fit';

    /**
     * File should cover the whole area (sublimation, posters
     */
    const FILL_MODE_COVER = 'cover';

    /**
     * @var int
     */
    public $printfileId;

    /**
     * Width in pixels
     *
     * @var int
     */
    public $width;

    /**
     * Height in pixels
     *
     * @var int
     */
    public $height;

    /**
     * Default DPI for printfile
     *
     * @var int
     */
    public $dpi;

    /**
     * Default mode for image. Should it cover the area or
     *
     * @var string
     */
    public $fillMode;

    /**
     * @param array $raw
     * @return PrintfileItem
     */
    public static function fromArray(array $raw)
    {
        $item = new PrintfileItem;

        $item->printfileId = (int)$raw['id'];
        $item->width = (int)$raw['width'];
        $item->height = (int)$raw['height'];
        $item->dpi = (int)$raw['dpi'];
        $item->fillMode = $raw['fill_mode'];

        return $item;
    }
}
<?php


namespace Printful\Structures\Generator;


use Printful\Structures\BaseItem;

/**
 * @see https://www.printful.com/docs/generator#actionPrintfiles
 * @see \Printful\PrintfulMockupGenerator::getProductPrintfiles()
 */
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
     * Indicates if printfile can be printed horizontal or vertical.
     * This is useful for posters, canvas, where the orientation of the actual print can be changed to accommodate image orientation.
     * That is, a 20x30 poster can be printed as 30x20 vertical poster if the image is vertical.
     *
     * @var bool
     */
    public $canRotate;

    /**
     * @param array $raw
     * @return PrintfileItem
     */
    public static function fromArray(array $raw)
    {
        $item = new PrintfileItem;

        $item->printfileId = (int)$raw['printfile_id'];
        $item->width = (int)$raw['width'];
        $item->height = (int)$raw['height'];
        $item->dpi = (int)$raw['dpi'];
        $item->fillMode = $raw['fill_mode'];
        $item->canRotate = (bool)$raw['can_rotate'];

        return $item;
    }

    /**
     * Width / height ratio
     * @return float
     */
    public function getRatio()
    {
        return $this->width / $this->height;
    }
}
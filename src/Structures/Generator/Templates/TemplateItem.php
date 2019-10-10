<?php


namespace Printful\Structures\Generator\Templates;


use Printful\Structures\BaseItem;

class TemplateItem extends BaseItem
{
    /**
     * Horizontal template orientation (used for wall art)
     */
    const ORIENTATION_HORIZONTAL = 'horizontal';
    /**
     * Any template orientation (used for wall art, usually means that the template is a square)
     */
    const ORIENTATION_ANY = 'any';
    /**
     * Vertical template orientation (used for wall art)
     */
    const ORIENTATION_VERTICAL = 'vertical';

    /**
     * Template's id
     * @var int
     */
    public $templateId;

    /**
     * Main template image URL
     * @var string
     * @see $isTemplateOnFront Indicates if this should be used as an overlay instead of a background.
     */
    public $imageUrl;

    /**
     * Indicates if the template image should be used as an overlay or a background for the positioning area
     * @var bool
     * @see $imageUrl
     */
    public $isTemplateOnFront;

    /**
     * Optional background template image URL
     * @var string|null
     */
    public $backgroundUrl;

    /**
     * Optional HEX color code that should be set as template background color
     * @var string
     */
    public $backgroundColor;

    /**
     * Id of the printfile that should be generated using given templates positions
     * @var int
     * @see \Printful\PrintfulMockupGenerator::getProductPrintfiles()
     * @see https://www.printful.com/docs/generator#actionPrintfiles
     */
    public $printfileId;

    /**
     * Main area width that the template image should be used in
     * @var int
     */
    public $templateWidth;

    /**
     * Main area height that the template image should be used in
     * @var int
     */
    public $templateHeight;

    /**
     * Active positioning area width within the template area
     * @var int
     */
    public $printAreaWidth;

    /**
     * Active positioning area height within the template area
     * @var int
     */
    public $printAreaHeight;

    /**
     * Active positioning area top offset from the template area
     * @var int
     */
    public $printAreaTop;

    /**
     * Active positioning area left offset from the template area
     * @var int
     */
    public $printAreaLeft;

    /**
     * @var string
     */
    public $orientation;

    /**
     * @param array $raw
     * @return TemplateItem
     */
    public static function fromArray(array $raw)
    {
        $item = new self;

        $item->templateId = (int)$raw['template_id'];
        $item->imageUrl = $raw['image_url'];
        $item->isTemplateOnFront = (bool)$raw['is_template_on_front'];
        $item->backgroundUrl = $raw['background_url'];
        $item->backgroundColor = $raw['background_color'];
        $item->printfileId = (int)$raw['printfile_id'];
        $item->templateWidth = (int)$raw['template_width'];
        $item->templateHeight = (int)$raw['template_height'];
        $item->printAreaWidth = (int)$raw['print_area_width'];
        $item->printAreaHeight = (int)$raw['print_area_height'];
        $item->printAreaTop = (int)$raw['print_area_top'];
        $item->printAreaLeft = (int)$raw['print_area_left'];
        $item->orientation = (string)$raw['orientation'];

        return $item;
    }
}
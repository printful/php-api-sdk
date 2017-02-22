<?php

namespace Printful\Structures\Order;

use Printful\Structures\BaseItem;

class OrderItemFile extends BaseItem
{

    const TYPE_PREVIEW = 'preview';
    const TYPE_DEFAULT = 'default';
    const TYPE_BACK = 'back';
    const TYPE_LEFT = 'left';
    const TYPE_RIGHT = 'right';
    const TYPE_LABEL = 'label';
    const TYPE_LABEL_INSIDE = 'label_inside';
    const TYPE_LABEL_OUTSIDE = 'label_outside';

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var string
     */
    public $mimeType;

    /**
     * @var int
     */
    public $size;

    /**
     * @var int
     */
    public $width;

    /**
     * @var int
     */
    public $height;

    /**
     * @var int
     */
    public $dpi;

    /**
     * @var string
     * ok - file was processed successfully
     * waiting - file is being processed
     * failed - file failed to be processed
     */
    public $status;

    /**
     * @var int - Timestamp
     */
    public $created;

    /**
     * @var string
     */
    public $thumbnailUrl;

    /**
     * @var string
     */
    public $previewUrl;

    /**
     * @var bool
     * Show file in the Printfile Library (default true)
     */
    public $visible;

    /**
     * @param array $raw
     * @return OrderItemFile
     */
    public static function fromArray(array $raw)
    {
        $file = new self;

        $file->id = (int)$raw['id'];
        $file->type = $raw['type'];
        $file->hash = $raw['hash'];
        $file->url = $raw['url'];
        $file->filename = $raw['filename'];
        $file->mimeType = $raw['mime_type'];
        $file->size = (int)$raw['size'];
        $file->width = (int)$raw['width'];
        $file->height = (int)$raw['height'];
        $file->dpi = (int)$raw['dpi'];
        $file->status = $raw['status'];
        $file->created = $raw['created'];
        $file->thumbnailUrl = $raw['thumbnail_url'];
        $file->previewUrl = $raw['preview_url'];
        $file->visible = (bool)$raw['visible'];

        return $file;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'url' => $this->url,
            'filename' => $this->filename,
            'visible' => $this->visible,
        ];
    }
}
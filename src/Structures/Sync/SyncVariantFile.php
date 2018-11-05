<?php

namespace Printful\Structures\Sync;

class SyncVariantFile
{
    /** @var int */
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $hash;

    /** @var string|null */
    public $url;

    /** @var string */
    public $filename;

    /** @var string */
    public $mimeType;

    /** @var int */
    public $size;

    /** @var int */
    public $width;

    /** @var int */
    public $height;

    /** @var int */
    public $dpi;

    /** @var string */
    public $status;

    /** @var int */
    public $created;

    /** @var string */
    public $thumbnailUrl;

    /** @var string */
    public $previewUrl;

    /** @var bool */
    public $visible;

    /**
     * Creates SyncVariantFile from array
     *
     * @param array $array
     * @return SyncVariantFile
     */
    public static function fromArray(array $array)
    {
        $file = new SyncVariantFile;

        $file->id = (int)$array['id'];
        $file->type = (string)$array['type'];
        $file->hash = (string)$array['hash'];
        $file->url = (string)$array['url'];
        $file->filename = (string)$array['filename'];
        $file->mimeType = (string)$array['mime_type'];
        $file->size = (int)$array['size'];
        $file->width = (int)$array['width'];
        $file->height = (int)$array['height'];
        $file->dpi = (int)$array['dpi'];
        $file->status = (string)$array['status'];
        $file->created = (int)$array['created'];
        $file->thumbnailUrl = (string)$array['thumbnail_url'];
        $file->previewUrl = (string)$array['preview_url'];
        $file->visible = (bool)$array['visible'];

        return $file;
    }
}
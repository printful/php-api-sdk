<?php

namespace Printful\Structures\Sync;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;

class SyncProductUpdateParameters extends SyncProductParameters
{
    /** @var SyncProductRequest|null */
    public $syncProduct;

    /** @var SyncVariantRequest[]|null */
    public $syncVariants;
}

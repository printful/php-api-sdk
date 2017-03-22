<?php

namespace Printful\Exceptions;

use Exception;

/**
 * Generic API exception
 */
class PrintfulException extends Exception
{
    /**
     * Last response from API that triggered this exception
     *
     * @var string
     */
    public $rawResponse;
}
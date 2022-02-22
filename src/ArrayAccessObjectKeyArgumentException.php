<?php

namespace Takemo101\LaravelSimpleVM;

use InvalidArgumentException;

/**
 * laravel array access object exception class
 */
final class ArrayAccessObjectKeyArgumentException extends InvalidArgumentException
{
    /**
     * constructor
     *
     * @param mixed $argument
     */
    public function __construct(mixed $argument)
    {
        $type = gettype($argument);

        parent::__construct(
            "invalid argument error: type [{$type}] cannot be used for the argument",
        );
    }
}

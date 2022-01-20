<?php

namespace Ajimoti\CacheTime\Exceptions;

use BadMethodCallException;

/**
 * @internal
 */
final class BadMethodException extends BadMethodCallException
{
    public function __construct($class, $methodName)
    {
        $this->message = sprintf(
            'Call to undefined method %s::%s()',
            $class,
            $methodName
        );
    }
}

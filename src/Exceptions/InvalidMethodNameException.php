<?php

namespace Ajimoti\CacheTime\Exceptions;

use BadMethodCallException;

/**
 * @internal
 */
final class InvalidMethodNameException extends BadMethodCallException
{
    public function __construct($methodName)
    {
        $this->message = "Could not retrieve number from method name, ensure method name [{$methodName}] is in camel case format";
    }
}

<?php

namespace Ajimoti\Timer\Traits;

use Ajimoti\Timer\Exceptions\BadMethodException;
use Ajimoti\Timer\Exceptions\InvalidMethodNameException;
use Ajimoti\Timer\Helpers\Str;

trait SupportsMagicCalls
{
    private static function allowedSuffixes(): array
    {
        $allowedSuffixes = ['second', 'minute', 'hour', 'day'];

        foreach ($allowedSuffixes as $allowedSuffix) {
            $allowedSuffixes[] = Str::simplePluralize($allowedSuffix);
        }

        return $allowedSuffixes;
    }

    public static function doMagic($methodName)
    {
        $method = null;
        foreach (static::allowedSuffixes() as $suffix) {
            if (Str::endsWith(strtolower($methodName), $suffix)) {
                $value = Str::wordsToNumber(
                    Str::studlyToSpaceSeparated(Str::eraseSuffix($methodName, $suffix))
                );

                $method = match ($suffix) {
                    'second' => 'seconds',
                    'minute' => 'minutes',
                    'hour' => 'hours',
                    'day' => 'days',
                    default => $suffix
                };

                break;
            }
        }

        if (empty($method)) {
            throw new BadMethodException(static::class, $methodName);
        }

        if (isset($method) && empty($value)) {
            throw new InvalidMethodNameException($methodName);
        }

        return static::$method($value);
    }
}

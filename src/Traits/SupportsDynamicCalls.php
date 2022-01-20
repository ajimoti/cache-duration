<?php

namespace Ajimoti\Timer\Traits;

use Ajimoti\Timer\Exceptions\BadMethodException;
use Ajimoti\Timer\Helpers\Str;

trait SupportsDynamicCalls
{
    /**
     * Get magic calls allowed suffixes.
     *
     * @var array
     */
    private static function allowedSuffixes(): array
    {
        $allowedSuffixes = ['second', 'minute', 'hour', 'day'];

        foreach ($allowedSuffixes as $allowedSuffix) {
            $allowedSuffixes[] = Str::simplePluralize($allowedSuffix);
        }

        return $allowedSuffixes;
    }

    /**
     * Handle dynamic method calls on the class.
     *
     * @var int
     */
    public static function dynamicCall($methodName): int
    {
        $wordsInMethodName = explode(' ', Str::studlyToSpaceSeparated($methodName));
        $suffix = end($wordsInMethodName);

        if (! in_array($suffix, static::allowedSuffixes())) {
            throw new BadMethodException(static::class, $methodName);
        }

        $value = Str::wordsToNumber(
            implode(' ', array_diff($wordsInMethodName, [$suffix]))
        );

        $method = match ($suffix) {
            'second' => 'seconds',
            'minute' => 'minutes',
            'hour' => 'hours',
            'day' => 'days',
            default => $suffix
        };

        return static::$method($value);
    }
}

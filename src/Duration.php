<?php

namespace Ajimoti\CacheDuration;

use Ajimoti\CacheDuration\Traits\SupportsDynamicCalls;
use Carbon\Carbon;
use DateTime;
use InvalidArgumentException;

final class Duration
{
    use SupportsDynamicCalls;

    /**
     * Returns the time in seconds.
     *
     * @param int $seconds
     */
    final public static function seconds(int $seconds = 1): int
    {
        return $seconds;
    }

    /**
     * Returns the number of minutes in seconds.
     *
     * @param int $minutes
     */
    final public static function minutes(int $minutes = 1): int
    {
        return static::seconds(60) * $minutes;
    }

    /**
     * Returns the number of hours in seconds.
     *
     * @param int $hours
     */
    final public static function hours(int $hours = 1): int
    {
        return static::minutes(60) * $hours;
    }

    /**
     * Returns the number of days in seconds.
     *
     * @param int $hours
     */
    final public static function days(int $days = 1): int
    {
        return static::hours(24) * $days;
    }

    /**
     * Returns the number of seconds between now and the time provided.
     *
     * @param DateTime|Carbon|string $value - string can be HH:MM:SS or HH:MM
     */
    final public static function at(DateTime|Carbon|string $value): int
    {
        if ($value instanceof Carbon) {
            $now = Carbon::now();

            if ($value->lte($now)) {
                throw new InvalidArgumentException("The value provided [{$value}] must be greater than [{$now}].");
            }

            return $value->diffInSeconds(Carbon::now());
        }

        if ($value instanceof DateTime) {
            return static::at(Carbon::instance($value));
        }

        if (is_string($value)) {
            return static::at(Carbon::parse($value));
        }

        throw new InvalidArgumentException('Invalid value provided.');
    }

    /**
     * Handle dynamic static method calls on the class.
     *
     * @var int
     */
    public static function __callStatic($methodName, $arguments)
    {
        return static::dynamicCall($methodName);
    }
}

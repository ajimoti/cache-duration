<?php

use Carbon\Carbon;
use Ajimoti\CacheTime\Time;

it('can return time in seconds', function () {
    expect(Time::seconds(1))->toBe(1);
});

it('can convert minutes to seconds', function () {
    $randomMinutes = random_int(1, 100);
    expect(Time::minutes($randomMinutes))->toBe(60 * $randomMinutes);
});

it('can convert hours to seconds', function () {
    $randomHours = random_int(1, 100);
    expect(Time::hours($randomHours))->toBe(60 * 60 * $randomHours);
});

it('can convert days to seconds', function () {
    $randomDay = random_int(1, 100);
    expect(Time::days($randomDay))->toBe(60 * 60 * 24 *$randomDay);
});

it('can calculate the difference in seconds between now and a provided date', function () {
    $twoWeeksTime = Carbon::now()->addWeeks(2);

    expect(Time::till($twoWeeksTime))->toBe(Carbon::now()->diffInSeconds($twoWeeksTime));
});

it('till method can accept a string', function () {
    $year = (int) date('Y') + 1;

    $sentence = "first day of January {$year}";

    expect(Time::till("{$year}-01-01"))->toBe(Carbon::createMidnightDate($year, 01, 01)->diffInSeconds(Carbon::now()));
    expect(Time::till($sentence))->toBe(Carbon::parse($sentence)->diffInSeconds(Carbon::now()));
});

it('till method accepts a string with seconds', function () {
    $year = (int) date('Y') + 1;
    $sentence = "first day of January {$year} 00:00:00";

    expect(Time::till($sentence))->toBe(Carbon::parse($sentence)->diffInSeconds(Carbon::now()));
});

it('till method accepts dateTime instance', function () {
    $year = (int) date('Y') + 1;
    $sentence = "first day of January {$year}";

    expect(Time::till(new \DateTime($sentence)))->toBe(Carbon::parse($sentence)->diffInSeconds(Carbon::now()));
});

it('till method accepts carbon instance', function () {
    $carbon = Carbon::now()->addMonths(2);

    expect(Time::till($carbon))->toBe($carbon->diffInSeconds(Carbon::now()));
});

it('till method throws an exception when a wrong type is passed', function () {
    Time::till(1);
})->throws(InvalidArgumentException::class);


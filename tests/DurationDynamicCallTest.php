<?php

use Ajimoti\CacheDuration\Duration;
use Ajimoti\CacheDuration\Exceptions\BadMethodException;

beforeEach(function () {
    $wordsToNumbers = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'twenty' => 20,
        'twentyThree' => 23,
        'thirty' => 30,
        'thirtySix' => 36,
        'forty' => 40,
        'fortyFour' => 44,
        'fifty' => 50,
        'fiftyOne' => 51,
    ];

    $this->numberInWord = array_rand($wordsToNumbers);
    $this->numberInDigit = $wordsToNumbers[$this->numberInWord];
});

it('can convert time to seconds dynamically', function () {
    expect(Duration::{$this->numberInWord . "Seconds"}())->toBe(Duration::seconds($this->numberInDigit));
    expect(Duration::{$this->numberInWord . "Second"}())->toBe(Duration::seconds($this->numberInDigit));
});

it('can convert minutes to seconds dynamically', function () {
    expect(Duration::{$this->numberInWord . "Minute"}())->toBe(Duration::minutes($this->numberInDigit));
    expect(Duration::{$this->numberInWord . "Minutes"}())->toBe(Duration::minutes($this->numberInDigit));
});

it('can convert hours to seconds dynamically', function () {
    expect(Duration::{$this->numberInWord . "Hour"}())->toBe(Duration::hours($this->numberInDigit));
    expect(Duration::{$this->numberInWord . "Hours"}())->toBe(Duration::hours($this->numberInDigit));
});

it('can convert days to seconds dynamically', function () {
    expect(Duration::{$this->numberInWord . "Day"}())->toBe(Duration::days($this->numberInDigit));
    expect(Duration::{$this->numberInWord . "Days"}())->toBe(Duration::days($this->numberInDigit));
});

it('throws an exception when the method name does not have a valid number in words', function () {
    expect(fn () => Duration::tenthMinute(1))->toThrow(InvalidArgumentException::class);
    expect(fn () => Duration::tinyDay(1))->toThrow(InvalidArgumentException::class);
    expect(fn () => Duration::fiftyfiveHours(1))->toThrow(InvalidArgumentException::class);
});

it('throws an exception when the method name does not have the correct suffix', function () {
    expect(fn () => Duration::fiveMinutenn(1))->toThrow(BadMethodException::class);
    expect(fn () => Duration::tenDayers(1))->toThrow(BadMethodException::class);
    expect(fn () => Duration::fiftyFiveHoures(1))->toThrow(BadMethodException::class);
});

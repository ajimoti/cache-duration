<?php

use Ajimoti\Timer\Exceptions\BadMethodException;
use Ajimoti\Timer\Time;

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
    expect(Time::{$this->numberInWord . "Seconds"}())->toBe(Time::seconds($this->numberInDigit));
    expect(Time::{$this->numberInWord . "Second"}())->toBe(Time::seconds($this->numberInDigit));
});

it('can convert minutes to seconds dynamically', function () {
    expect(Time::{$this->numberInWord . "Minute"}())->toBe(Time::minutes($this->numberInDigit));
    expect(Time::{$this->numberInWord . "Minutes"}())->toBe(Time::minutes($this->numberInDigit));
});

it('can convert hours to seconds dynamically', function () {
    expect(Time::{$this->numberInWord . "Hour"}())->toBe(Time::hours($this->numberInDigit));
    expect(Time::{$this->numberInWord . "Hours"}())->toBe(Time::hours($this->numberInDigit));
});

it('can convert days to seconds dynamically', function () {
    expect(Time::{$this->numberInWord . "Day"}())->toBe(Time::days($this->numberInDigit));
    expect(Time::{$this->numberInWord . "Days"}())->toBe(Time::days($this->numberInDigit));
});

it('throws an exception when the method name does not have a valid number in words', function () {
    expect(fn () => Time::tenthMinute(1))->toThrow(InvalidArgumentException::class);
    expect(fn () => Time::tinyDay(1))->toThrow(InvalidArgumentException::class);
    expect(fn () => Time::fiftyfiveHours(1))->toThrow(InvalidArgumentException::class);
});

it('throws an exception when the method name does not have the correct suffix', function () {
    expect(fn () => Time::fiveMinutenn(1))->toThrow(BadMethodException::class);
    expect(fn () => Time::tenDayers(1))->toThrow(BadMethodException::class);
    expect(fn () => Time::fiftyFiveHoures(1))->toThrow(BadMethodException::class);
});

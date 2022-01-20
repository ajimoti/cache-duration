<?php

use Ajimoti\CacheTime\Helpers\Str;

it('can correctly pluralize method names', function () {
    $singleToPlural = [
        'second' => 'seconds',
        'minute' => 'minutes',
        'hour' => 'hours',
        'day' => 'days',
    ];

    foreach ($singleToPlural as $single => $plural) {
        expect(Str::simplePluralize($single))->toBe($plural);
    }
});

it('can correctly convert words to numbers', function() {
    $wordsToNumbers = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'twenty' => 20,
        'twenty three' => 23,
        'thirty' => 30,
        'thirty six' => 36,
        'forty' => 40,
        'forty four' => 44,
        'fifty' => 50,
        'fifty one' => 51,
        'fifty two' => 52,
        'sixty three' => 63,
    ];

    foreach ($wordsToNumbers as $word => $number) {
        expect(Str::wordsToNumber($word))->toBe($number);
    }
});

it ('can correctly convert studly to space separated', function() {
    $studlyCaseToSpaceSeparated = [
        'thisIsALongWord' => 'this is a long word',
        'thisIsALongWordWithNumbers' => 'this is a long word with numbers',
        'thisIsALongWordWithNumbersAndSymbols' => 'this is a long word with numbers and symbols',
        'iNeedAJob' => 'i need a job',
    ];

    foreach ($studlyCaseToSpaceSeparated as $studly => $space) {
        expect(Str::studlyToSpaceSeparated($studly))->toBe($space);
    }
});

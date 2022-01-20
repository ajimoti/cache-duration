<?php

namespace Ajimoti\Timer\Helpers;

use InvalidArgumentException;
use SplStack;

class Str
{
    /**
     * The cache of words that will be converted to number.
     *
     * @var array
     */
    protected static $wordsToNumberCache = [];

    /**
     * Get the plural of a string.
     *
     * Basically appends an `s` to argument provided
     *
     * @param string $word
     *
     * @return string
     */
    public static function simplePluralize(string $word): string
    {
        return $word . 's';
    }

    /**
    * Convert a string such as "one hundred thousand" to 100000
    * This is useful for converting strings like "one hundred thousand" to numbers.
    *
    * Credit: https://stackoverflow.com/a/11219737/16163383
    *
    * @param string $data The numeric string.
    *
    * @return int The numeric value.
    */
    public static function wordsToNumber($data): int
    {
        if (isset(static::$wordsToNumberCache[$data])) {
            return static::$wordsToNumberCache[$data];
        }

        $wordsToValue = [
            'zero' => '0',
            'a' => '1',
            'one' => '1',
            'two' => '2',
            'three' => '3',
            'four' => '4',
            'five' => '5',
            'six' => '6',
            'seven' => '7',
            'eight' => '8',
            'nine' => '9',
            'ten' => '10',
            'eleven' => '11',
            'twelve' => '12',
            'thirteen' => '13',
            'fourteen' => '14',
            'fifteen' => '15',
            'sixteen' => '16',
            'seventeen' => '17',
            'eighteen' => '18',
            'nineteen' => '19',
            'twenty' => '20',
            'thirty' => '30',
            'forty' => '40',
            'fourty' => '40', // common misspelling
            'fifty' => '50',
            'sixty' => '60',
            'seventy' => '70',
            'eighty' => '80',
            'ninety' => '90',
            'hundred' => '100',
            'thousand' => '1000',
            'million' => '1000000',
            'billion' => '1000000000',
            'and' => '',
        ];

        $data = strtolower($data);
        $validWords = array_keys($wordsToValue);

        // Ensure every word provided is valid
        foreach (explode(' ', $data) as $word) {
            if (! in_array($word, $validWords)) {
                throw new InvalidArgumentException(sprintf(
                    'Invalid word "%s" in number "%s". Ensure words are in camel case format',
                    $word,
                    $data
                ));
            }
        }

        // Replace all number words with an equivalent numeric value
        $data = strtr($data, $wordsToValue);

        // Coerce all tokens to numbers
        $parts = array_map(
            function ($val) {
                return floatval($val);
            },
            preg_split('/[\s-]+/', $data)
        );

        $stack = new SplStack(); // Current work stack
        $sum = 0; // Running total
        $last = null;

        foreach ($parts as $part) {
            if (! $stack->isEmpty()) {
                // We're part way through a phrase
                if ($stack->top() > $part) {
                    // Decreasing step, e.g. from hundreds to ones
                    if ($last >= 1000) {
                        // If we drop from more than 1000 then we've finished the phrase
                        $sum += $stack->pop();
                        // This is the first element of a new phrase
                        $stack->push($part);
                    } else {
                        // Drop down from less than 1000, just addition
                        // e.g. "seventy one" -> "70 1" -> "70 + 1"
                        $stack->push($stack->pop() + $part);
                    }
                } else {
                    // Increasing step, e.g ones to hundreds
                    $stack->push($stack->pop() * $part);
                }
            } else {
                // This is the first element of a new phrase
                $stack->push($part);
            }

            // Store the last processed part
            $last = $part;
        }

        return static::$wordsToNumberCache[$data] = (int) ($sum + $stack->pop());
    }

    /**
     * Convert a studly case string to space separated words.
     *
     * @param string $string
     *
     * @return string
     */
    public static function studlyToSpaceSeparated(string $string): string
    {
        $words = array_map(function ($word) {
            return strtolower($word);
        }, preg_split('/(?=[A-Z])/', $string));

        return implode(' ', $words);
    }
}

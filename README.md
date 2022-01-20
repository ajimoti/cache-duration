# PHP Cache Duration
![Banner](https://banners.beyondco.de/Cache%20Time%20Package.png?theme=dark&packageManager=composer+require&packageName=ajimoti%2Fcache-time&pattern=charlieBrown&style=style_1&description=A+more+readable+way+to+get+time+in+seconds+while+caching&md=1&showWatermark=1&fontSize=100px&images=clock)

## Introduction
A readable and fluent way to generate PHP cache time.

Built and written by [Ajimoti Ibukun](https://www.linkedin.com/in/ibukun-ajimoti-3420a786/)

## Quick Samples
Instead of this:
```php
$cacheDuration = 25 * 60 * 60; // twenty five hours
Redis::expire(['example'], $cacheDuration);
```

You can do this
```php
$cacheDuration = Duration::twentyFiveHours(); // returns 25 hours in seconds (25 * 60 * 60)
Redis::expire(['example'], $cacheDuration);

// or
$cacheDuration = Duration::hours(25); // returns 25 hours in seconds (25 * 60 * 60)
Redis::expire(['example'], $cacheDuration);
```

You can also do this:
```php
$cacheDuration = Duration::at('first day of January 2023'); // returns the time difference between the present time and the first of january 2023 in seconds

Redis::expire(['example'], $cacheDuration);
```

## Requirements
- PHP 8.0 or higher

## Installation
You can install the package via composer:
```bash
composer require ajimoti/cache-duration --with-all-dependencies
```

## Documentation
After installing the package via composer, import the `Duration` trait inside your class, then you are set.
```php
<?php
require 'vendor/autoload.php';

Use Ajimoti\CacheDuration\Duration;

var_dump(Duration::fourtyMinutes()); // returns 2400;
var_dump(Duration::tenHours()); // returns 36000;
var_dump(Duration::fiftyFourDays()); // returns 4665600;
```

### Available methods
| Method      | Expectations | 
| ----------- | ----------- |
| [seconds($value)](#secondsvalue)  | Expects time in seconds  |
| [minutes($value)](#minutesvalue)   | Expects time in minutes  |
| [hours($value)](#hoursvalue)  | Expects time in hours  |
| [days($value)](#daysvalue) | Expects time in days  |
| [at($value)](#atvalue)  | Expects `string`, `carbon` instance, or `DateTime` instance  |

### Dynamic calls
In addition to the methods provided above, the package uses `PHP` `__callStatic()` method to allow you make dynamic calls on the `Duration` trait.

For example, you want to get the number of seconds in 37 days, you can achieve this by calling a `studly-case` text of the number (`thirtySeven` in this case), plus the unit (`Days` in this case). That will leave us with something like this:

```php
// The formula = studlyCaseOfTheNumberInWords + Unit
Duration::thirtySevenDays(); // returns the number of seconds in 37 days
```

> **Note:** The number in words **MUST** be in `studly-case`. Any other case will throw an `InvalidArgumentException`. Additionally, it must be followed by a `title-case` of the unit. The available units are `Seconds`, `Minutes`, `Hours`, and `Days`.


## Usage
### `seconds($value)`
Get time in seconds. It basically returns the same value passed into it.
```php
Use Ajimoti\CacheDuration\Duration;

$cacheDuration = Duration::seconds(30); // returns 30

// or dynamically
$cacheDuration = Duration::thirtySeconds(); // returns 30
```

### `minutes($value)`
Converts time in minutes into seconds.
```php
Use Ajimoti\CacheDuration\Duration;

$cacheDuration = Duration::minutes(55); // returns 55 minutes in seconds (55 * 60)

// or dynamically
$cacheDuration = Duration::fiftyFiveMinutes(); // returns 55 minutes in seconds (55 * 60)
```

### `hours($value)`
Converts time in hours into seconds.
```php
Use Ajimoti\CacheDuration\Duration;

$cacheDuration = Duration::hours(7); // returns 7 hours in seconds (7 * 60 * 60)

// or dynamically
$cacheDuration = Duration::sevenHours(); // returns 7 hours in seconds (7 * 60 * 60)
```

### `days($value)`
Converts time in days into seconds.
```php
Use Ajimoti\CacheDuration\Duration;

$cacheDuration = Duration::days(22); // returns 22 days in seconds (22 * 24 * 60 * 60)

// or dynamically
$cacheDuration = Duration::twentyTwoHours(); // returns 22 days in seconds (22 * 24 * 60 * 60)
```

### `at($value)`
This method allows you to convert a `Carbon\Carbon` instance, `DateTime` instance or  `string` of date into seconds. 

The method returns the difference in seconds between the argument passed and the current `timestamp`.

> The date passed into this method **MUST** be a date in the future. When a string is passed, the text **MUST** be compatible with `Carbon::parse()` method, else an exception will be thrown

#### Examples
```php
use Date;
use Carbon\Carbon;
use Ajimoti\CacheDuration\Duration;

// Carbon instance
$cacheDuration = Duration::at(Carbon::now()->addMonths(3)); // returns time in seconds between the present timestamp and three months time

// Datetime instance
$cacheDuration = Duration::at(new DateTime('2039-09-30')); // returns time in seconds between the present timestamp and the date passed (2039-09-30).

// String
$cacheDuration = Duration::at('first day of January 2023'); // returns time in seconds between the present timestamp and the first of January 2023.
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [ajimoti](https://github.com/ajimoti)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# php-elog

Simple PHP class for enhanced error logging.

## Installation

```bash
composer require tintonic/php-elog
```

## Usage

### Simple usage – create instance and log via helpers

This example creates an `Elog` instance that will log to a file named `elog.log` in the same directory as executing script (`__DIR__`). The helper function `elog()` logs to the instance of `Elog` that was first created.

```php
create_elog();

/*
Logs to the first instance that was created.
Logs to __DIR__/elog.log
*/
elog("I am elog.log");
```

### Logging different data types

* `null` is presented as `[null]`
* `empty string` is presented as `[empty string]`
* `true` is presented as `[true]`
* `false` is presented as `[false]`
* `object` and `arrays` is presented using `print_r()`

```php
create_elog();

elog(null);  // [null]

elog('');    // [empty string]

elog(true);  // [true]

elog(false); // [false]


elog((object) [
    'id' => 123,
    'foo' => 'bar'
]);

/*
stdClass Object
(
    [id] => 123
    [foo] => bar
)
*/


elog([
    'id' => 123,
    'foo' => 'bar'
]);

/*
Array
(
    [id] => 123
    [foo] => bar
)
*/
```


### Include label and / or data type

```php
elog(true, 'Current value', true);

/*
--- Current value {boolean} ---
[true]
*/
```


### Named instances

This example creates two named `Elog` instances – one that logs to `_DIR__/first.log` and another that logs to `/path/to/log/second_log_file` (without file extension).

```php
create_elog(__DIR__, 'first');
create_elog('/path/to/log', 'second', 'second_log_file', null);

// Log to named instances using elogn().
elogn('first', "I am first.log");         //  ———>  __DIR__/first.log
elogn('second', "I am second_log_file");  //  ———>  /path/to/log/second_log_file
```

### Using the Elog class

Of course you may use the underlying `Elog` class directly. This way you can configure a default value for `$include_type` to always log data type.

```php
use Tintonic/PhpElog/Elog;

$logger = new Elog('/path/to/log', 'elog', 'elog', 'log');

$logger->set_default_include_type(true);


$logger->log(123);

/*
{integer} 
123
*/


$logger->log('foo bar', 'What?');

/*
--- What? {string} ---
foo bar
*/

```
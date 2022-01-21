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

// Log to default (first) instance using elog().
elog("I am elog.log");  //  ———> __DIR__/elog.log
```

### Named instances

This example creates two `Elog` instances – one that logs to `_DIR__/first.log` and another that logs to `/path/to/log/second_log_file` (without file extension).

```php
create_elog(__DIR__, 'first');
create_elog('/path/to/log', 'second', 'second_log_file', null);

// Log to named instances using elogn().
elogn('first', "I am first.log");         //  ———>  __DIR__/first.log
elogn('second', "I am second_log_file");  //  ———>  /path/to/log/second_log_file
```

###
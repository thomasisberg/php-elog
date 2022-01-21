# php-elog

Simple PHP class for enhanced error logging.

## Installation

```bash
composer require tintonic/php-elog
```

## Usage

### Simple usage – create instance and log via helper

This example creates an *Elog* instance that will log to a file named **elog.log** in the same directory as executing script.

The helper function elog() logs to the instance of *Elog* that was first created.

```php
use Tintonic\PhpElog\Elog;

new Elog();
elog("Hey, I'm elog.log");
```

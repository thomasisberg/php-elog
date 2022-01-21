# php-elog

Simple PHP class for enhanced error logging.

## Usage

### Simple usage – create instance and log via helper.

This example creates an Elog instance that will log to a file named **elog.log** in a parent directory 3 levels up from executing script.

```php
new Elog(__DIR__, 3);
elog("Hey, I'm elog.log");
```

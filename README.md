# Logger
Logger for PHP

## SetUp

```
composer install
```

## Example

```php
<?php
require_once "Logger.php";

$data = [1, 2, "foo"];
Logger::dumpLog("debug.log", $data);
```

## Test

```bash
./vendor/bin/phpunit test
```

## Static Analysis

```bash
./vendor/bin/phpstan
```
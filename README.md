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
composer test
```

or

```bash
./vendor/bin/phpunit test
```

## Static Analysis

```bash
composer cs
```

or

```bash
./vendor/bin/phpstan
```
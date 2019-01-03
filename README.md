# laravel-keyvalue

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run


```shell
php composer.phar require --prefer-dist stevenlei/laravel-keyvalue "^1.0"
```

or add

```shell
"stevenlei/laravel-keyvalue": "^1.0"
```

to the require section of your `composer.json` file.

## Environment Requirements

- PHP >= 7.1.3
- Laravel >= 5.6
- Bootstrap >= 4.0

## Usage

- 1. Registering Provider in the `config/app.php` configuration file:

```php
'providers' => [
    // ...
    StevenLei\LaravelKeyValue\ServiceProvider::class,
],

'aliases' => [
    // ...
    'KeyValue' => StevenLei\LaravelKeyValue\Facade::class,
],
```

- 2. Create configuration files:

```shell
php artisan vendor:publish --provider="StevenLei\LaravelKeyValue\ServiceProvider"
```

- 3. Modify the configuration file: `config/keyvalue.php`


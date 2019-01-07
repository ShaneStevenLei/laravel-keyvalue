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

- 3. The configuration file: `config/keyvalue.php`, modify the configuration items in the `.env` file, for example:

```
KEY_VALUE_PREFIX=KV_
KEY_VALUE_TTL=7200
KEY_VALUE_USERNAME=username
KEY_VALUE_MIDDLEWARE=web,auth
```

- 4. How to get the key's value in the program?

```php
# Get the string value
StevenLei\LaravelKeyValue\Facade::getValue($key, $throwException = true);
# Get the json object
StevenLei\LaravelKeyValue\Facade::getJsonValue($key, $throwException = true);
# Get the array
StevenLei\LaravelKeyValue\Facade::getArrayValue($key, $throwException = true);
# Get the collection
StevenLei\LaravelKeyValue\Facade::getCollectionValue($key, $throwException = true);
```

or use the helper function

```php
kv_get($key, $type = KeyValue::TYPE_STRING, $throwException = true);
```

## Routes

- Index page
    - `/key-value/index`
    - alias: `keyvalue.index`
- Create page or store resource
    -  `/key-value/create`
    - alias: `keyvalue.create`
- Update page or update resource
    - `/key-value/update`
    - alias: `keyvalue.update`
- Delete resource(only soft delete)
    - `/key-value/delete`
    - alias: `keyvalue.delete`

## Middleware

Add middleware in the `.env` file, separated by commas, for example:

```
KEY_VALUE_MIDDLEWARE=web,auth
```
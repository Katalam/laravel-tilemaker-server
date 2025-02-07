# Tilemaker Server for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/katalam/laravel-tilemaker-server.svg?style=flat-square)](https://packagist.org/packages/katalam/laravel-tilemaker-server)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/katalam/laravel-tilemaker-server/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/katalam/laravel-tilemaker-server/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/katalam/laravel-tilemaker-server/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/katalam/laravel-tilemaker-server/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/katalam/laravel-tilemaker-server.svg?style=flat-square)](https://packagist.org/packages/katalam/laravel-tilemaker-server)

## Installation

You can install the package via composer:

```bash
composer require katalam/laravel-tilemaker-server
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-tilemaker-server-config"
```

This is the contents of the published config file:

```php
return [
    'database' => [
        'connection' => env('TILEMAKER_DB_CONNECTION', 'tiles'),
    ],

    'routes' => [
        'prefix' => env('TILEMAKER_ROUTE_PREFIX', ''),
        'as' => env('TILEMAKER_ROUTE_PREFIX', '').'.',
    ],
];
```

## Usage
```bash
php artisan tilemaker-server:install
```
You will get the following files:
* Fonts inside the storage folder
* spec.json inside the storage folder
* style.json inside the storage folder
* map css imported to app.css

Change spec and style settings to your needs.
Make sure to link storage folder
```bash
php artisan storage:link
```

Import fetch meta-data and the map variable from map.js
```js
import { Map } from "./map.js";

const map = new Map
map.init()
    .then(() => {
        map.getRoute()
            .then(data => {
                map.displayRoute(data)
            })
    });
```
You will see a map with the default settings.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bruno Görß](https://github.com/Katalam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

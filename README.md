# A simple resource for managing users in Filament.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/filament-user-resource.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-user-resource)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-user-resource/run-tests?label=tests)](https://github.com/ryangjchandler/filament-user-resource/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-user-resource/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/filament-user-resource/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/filament-user-resource.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-user-resource)

This package provides a `UserResource` class that lets you create and update `User` models from Filament. This is designed to work with Laravel's default `User` model.

## Installation

You can install the package via Composer:

```bash
composer require ryangjchandler/filament-user-resource
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-user-resource-config"
```

## Usage

The `UserResource` class is automatically registered with Filament so there's very little setup.

### Enabling password changes

By default, the password for a `User` **can't** be updated from Filament. This is a personal preference, but can be enabled by calling `UserResource::enablePasswordUpdates()` inside of a service provider.

```php
use RyanChandler\FilamentUserResources\Resources\UserResource;

public function boot()
{
    UserResource::enablePasswordUpdates();
}
```

You can also provide a callback function to this method to conditionally enable password updates, e.g. allowing administrators to update passwords but not other users.

```php
use RyanChandler\FilamentUserResources\Resources\UserResource;

public function boot()
{
    UserResource::enablePasswordUpdates(function (): bool {
        return auth()->user()->role === Role::Admin;
    });
}
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

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

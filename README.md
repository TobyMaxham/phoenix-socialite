# PhoenixII OAuth2 Provider for Laravel Socialite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tobymaxham/phoenix-socialite.svg?style=flat-square)](https://packagist.org/packages/tobymaxham/phoenix-socialite)
[![Tests](https://github.com/tobymaxham/phoenix-socialite/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/tobymaxham/phoenix-socialite/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/tobymaxham/phoenix-socialite.svg?style=flat-square)](https://packagist.org/packages/tobymaxham/phoenix-socialite)

---

This package can be used to add a Laravel Socialite driver using the PhoenixII OAuth2-API.

If you do not have a laravel installation, please check out my other package which can be used without a framework:
https://github.com/TobyMaxham/phoenixii-oauth2

## Installation

```bash
composer require tobymaxham/phoenix-socialite
```

## Configuration & Basic Usage

As an organisation using PhoenixII you can use this package for any third party software to enable OAuth2.
This will give your users an easy and comfortable way to use the third party application. A users wich is already
a registered user on your PhoenixII instance, they do not need to register a second account on your platform.

For more information read the documentation: https://tricept.atlassian.net/wiki/spaces/PIIWIKI/pages/976912387/OAuth+2+-+Schnittstelle

### Add configuration to `config/services.php`

```php
'phoenix-auth' => [
   'instance' => 'https://{instance}.it4sport.de',
   'client_id' => env('PHOENIX_CLIENT_ID'),  
   'client_secret' => env('PHOENIX_CLIENT_SECRET'),  
   'redirect' => env('PHOENIX_REDIRECT_URI'),
   'token' => env('PHOENIX_BEARER_TOKEN'),
],
```

## Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('phoenix-auth')->redirect();
```

### Returned User fields

- ``id``
- ``firstname``
- ``lastname``
- ``email``
- ``birthday``
- ``organisation``
- ``licenses``
- ``functions``
- ``addresses``

## Important note

This package is not developed or maintained by PhoenixII (it4sport). This package was created using
the public [OAuth-Documentation](https://tricept.atlassian.net/wiki/spaces/PIIWIKI/pages/976912387/OAuth+2+-+Schnittstelle).

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

- [TobyMaxham](https://github.com/TobyMaxham)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

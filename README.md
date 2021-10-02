# Laravel - Thai Bulk SMS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ibnuhalimm/laravel-thai-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/ibnuhalimm/laravel-thai-bulk-sms)
[![Total Downloads](https://img.shields.io/packagist/dt/ibnuhalimm/laravel-thai-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/ibnuhalimm/laravel-thai-bulk-sms)

Laravel wrapper for [Thai Bulk SMS](https://www.thaibulksms.com/).

## Installation

You can install the package via composer:

```bash
composer require ibnuhalimm/laravel-thai-bulk-sms
```

Optionaly, you can publish the config file of this package with this command:
```bash
php artisan vendor:publish --provider="Ibnuhalimm\LaravelThaiBulkSms\ServiceProvider"
```

## Usage

```php
use LaravelThaiBulkSms;

// Send the sms to single recipient
$phoneNumber = '+6612345678';
$message = 'Hi, our message here.';
LaravelThaiBulkSms::send($phoneNumber, $message);

// Send the sms to multiple phone number
$phoneNumber = [
    '+6612345678',
    '+6690111213',
];
$message = 'Hi, our message here.';
LaravelThaiBulkSms::send($phoneNumber, $message);


// The response format of this package will be like this
{#312 ▼
  +"code": 400
  +"data": null
  +"error": {#310 ▼
    +"name": "ERROR_INSUFFICIENT_CREDIT"
    +"description": "Insufficient credit."
  }
}
```

The data, error name and description based on the thai bulk sms response. You can see them [here](https://assets.thaibulksms.com/documents/ThaibulksmsAPIDocument_V2.0_EN.pdf)

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ibnuhalimm@gmail.com instead of using the issue tracker.

## Credits

-   [Ibnu Halim Mustofa](https://github.com/ibnuhalimm)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


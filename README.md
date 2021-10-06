# Laravel - Thai Bulk SMS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ibnuhalimm/laravel-thai-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/ibnuhalimm/laravel-thai-bulk-sms)
[![Total Downloads](https://img.shields.io/packagist/dt/ibnuhalimm/laravel-thai-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/ibnuhalimm/laravel-thai-bulk-sms)

Laravel wrapper for [Thai Bulk SMS](https://www.thaibulksms.com/).

## Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Setting Up](#setting-up)
- [Usage](#usage)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Requirements
1. [Sign Up](https://account.thaibulksms.com/register/) for the Thai Bulk SMS Account
2. Create a Api Key and Secret Key in Setting section

## Installation

You can install the package via composer:

```bash
composer require ibnuhalimm/laravel-thai-bulk-sms
```

Optionally, you can publish the config file of this package with this command:
```bash
php artisan vendor:publish --provider="Ibnuhalimm\LaravelThaiBulkSms\ThaiBulkSmsServiceProvider"
```

## Setting up
Put your `API Key` and `Secret Key` to `.env` file:
```bash
THAI_BULK_API_KEY=
THAI_BULK_SECRET_KEY=
```

## Usage

1. You can directly use the `ThaiBulkSms` Facade (the alias or class itself):
    ```php
    use Ibnuhalimm\LaravelThaiBulkSms\Facades\ThaiBulkSms;

    // Send the sms to single recipient
    $phoneNumber = '+6612345678';
    $message = 'Hi, our message here.';
    ThaiBulkSms::send($phoneNumber, $message);

    // Send the sms to multiple phone number
    $phoneNumber = [
        '+6612345678',
        '+6690111213',
    ];
    $message = 'Hi, our message here.';
    ThaiBulkSms::send($phoneNumber, $message);
    ```
    The response format of this method will be like [Thai Bulk SMS API's Response](https://assets.thaibulksms.com/documents/ThaibulksmsAPIDocument_V2.0_EN.pdf).
<br><br>
2. Notifications
    <br>Let's take a look at the implementation as Notifications Channel.
    ```php
    use Ibnuhalimm\LaravelThaiBulkSms\ThaiBulkSmsChannel;
    use Ibnuhalimm\LaravelThaiBulkSms\ThaiBulkSmsMessage;
    use Illuminate\Notifications\Notification;

    class VerifyMobileNumber extends Notification
    {
        public function via()
        {
            return [ThaiBulkSmsChannel::class];
        }

        public function toThaiBulkSms($notifiable)
        {
            return (new ThaiBulkSmsMessage())
                ->message("Your OTP to complete the registration is {$this->otp}");
        }
    }
    ```

    In order to let the notification know which mobile phone number are you sending to, by default the channel will look for the `mobile_number` attribute of Notifiable model. If you want to override this behaviour, add the `routeNotificationForThaiBulkSms` method in your Notifiable model.
    ```php
    public function routeNotificationForThaiBulkSms()
    {
        return $this->phone;
    }
    ```
    or set the recipient mobile number directly to the notifiable instance using `to` method
    ```php
    ...
    public function toThaiBulkSms($notifiable)
    {
        return (new ThaiBulkSmsMessage())
            ->message("Your OTP to complete the registration is {$notifiable->otp}")
            ->to($notifiable->phone); // add this
    }
    ...
    ```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email ibnuhalimm@gmail.com instead of using the issue tracker.

## Credits

-   [Ibnu Halim Mustofa](https://github.com/ibnuhalimm)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


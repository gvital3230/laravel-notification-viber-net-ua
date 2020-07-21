# ViberNetUa Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/vibernetua.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vibernetua)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/vibernetua/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/vibernetua)
[![StyleCI](https://styleci.io/repos/234812852/shield)](https://styleci.io/repos/234812852)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/vibernetua.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vibernetua)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/vibernetua/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vibernetua/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/vibernetua.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vibernetua)

This package makes it easy to send notifications using [ViberNetUa](https://viber.net.ua) with Laravel 5.5+, 6.0 and 7.0

## Contents

- [Installation](#installation)
	- [Setting up the ViberNetUa service](#setting-up-the-ViberNetUa-service)
- [Usage](#usage)
	- [ On-Demand Notifications](#on-demand-notifications)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
``` bash
composer require gvital3230/laravel-notification-channel-viber-net-ua
```

### Setting up the ViberNetUa service

Add your ViberNetUa sms gate login, password and default sender name to your config/services.php:

```php
// config/services.php
...
    'vibernetua' => [
        'endpoint' => env('VIBERNETUA_ENDPOINT', 'https://my2.viber.net.ua/api/v2/viber/dispatch'),
        'token' => env('VIBERNETUA_TOKEN'),
        'sender' => env('VIBERNETUA_SENDER'),
        'debug' => env('VIBERNETUA_DEBUG'),
        'sandboxMode' => env('VIBERNETUA_SANDBOX_MODE', false),
    ],
...
```

## Usage

You can use the channel in your via() method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\ViberNetUa\ViberNetUaMessage;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return ['vibernetua'];
    }

    public function toViberNetUa($notifiable)
    {
        return (new ViberNetUaMessage(
            \NotificationChannels\ViberNetUa\ViberNetUaMessageType::TYPE_ONLY_MESSAGE(), 
            'Account approved', 
            'Congratulations, your accaunt was approved!'));       
    }
}
```

In your notifiable model, make sure to include a routeNotificationForViberNetUa() method, which returns a phone number or an array of phone numbers.

```php
public function routeNotificationForViberNetUa()
{
    return $this->phone;
}
```

### On-Demand Notifications
Sometimes you may need to send a notification to someone who is not stored as a "user" of your application. Using the Notification::route method, you may specify ad-hoc notification routing information before sending the notification:

```php
Notification::route('vibernetua', '+380501111111')                      
            ->notify(new AccountApproved());
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email 1c.audit@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Vitalii Goncharov](https://github.com/gvital3230)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

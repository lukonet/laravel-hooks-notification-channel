# Hooks Notifications Channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lukonet/laravel-hooks-notification-channel.svg?style=flat-square)](https://packagist.org/packages/lukonet/laravel-hooks-notification-channel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/lukonet/laravel-hooks-notification-channel/master.svg?style=flat-square)](https://travis-ci.org/lukonet/laravel-hooks-notification-channel)
[![StyleCI](https://styleci.io/repos/66031746/shield)](https://styleci.io/repos/66031746)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/bab0e656-1dc8-4135-9c3b-702453aa0f74.svg?style=flat-square)](https://insight.sensiolabs.com/projects/bab0e656-1dc8-4135-9c3b-702453aa0f74)
[![Quality Score](https://img.shields.io/scrutinizer/g/lukonet/laravel-hooks-notification-channel.svg?style=flat-square)](https://scrutinizer-ci.com/g/lukonet/laravel-hooks-notification-channel)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/lukonet/laravel-hooks-notification-channel/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/lukonet/laravel-hooks-notification-channel/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/lukonet/laravel-hooks-notification-channel.svg?style=flat-square)](https://packagist.org/packages/lukonet/laravel-hooks-notification-channel)

> **UPDATE:** It seems like the Hooks service is no longer active, hence, this project has been archived.

This package makes it easy to send notifications using [Hooks](http://www.gethooksapp.com/) with Laravel 5.3. 

Hooks API lets you send a notification to all users subscribed to your custom alert.

## Contents

- [Installation](#installation)
	- [Setting up the Hooks service](#setting-up-the-hooks-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require lukonet/laravel-hooks-notification-channel
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Hooks\HooksServiceProvider::class,
],
```

## Setting up the Hooks service

1. Sign up for a developer account on [Hooks](https://dev.gethooksapp.com/) site.
2. Get the API Key, located in the [account page](https://dev.gethooksapp.com/users).
3. Create a custom alert on [alerts page](https://dev.gethooksapp.com/alerts).
4. Obtain the alert id associated with your notification, located in your [alerts page](https://dev.gethooksapp.com/alerts). It'll be used when sending a notification.

Then, configure your Hooks API Key by adding it to the `config/services.php` file:

```php
// config/services.php
...
'hooks' => [
    'key' => env('HOOKS_API_KEY', 'YOUR HOOKS API KEY HERE')
],
...
```

## Usage

You can now use the channel in your `via()` method inside the Notification class.

``` php
use NotificationChannels\Hooks\HooksChannel;
use NotificationChannels\Hooks\HooksMessage;
use Illuminate\Notifications\Notification;

class NewsUpdate extends Notification
{
    public function via($notifiable)
    {
        return [HooksChannel::class];
    }

    public function toHooks($notifiable)
    {
        $url = url('/news/' . $notifiable->id);

        return HooksMessage::create()
            ->alertId('<Hooks Alert ID>') // Optional.
            ->message('Laravel 5.3 launches with the all new notifications feature!')
            ->url($url);
    }
}
```

Here's a screenshot preview of the above notification on Hooks App:

![Laravel Hooks Notification Example](https://cloud.githubusercontent.com/assets/1915268/17791360/63550c58-65b8-11e6-84d3-cc5db57a0f80.jpg)

### Routing a message

You can either send the notification by providing with the alert id to the `alertId($alertId)` method like shown in the above example or add a `routeNotificationForHooks()` method in your notifiable model:

``` php
...
/**
 * Route notifications for the Hooks channel.
 *
 * @return int
 */
public function routeNotificationForHooks()
{
    return 'YOUR ALERT ID HERE';
}
...
```

### Available Message methods

- `alertId($alertId)`: (integer) The alert id associated with your notification, located in your [alerts page](https://dev.gethooksapp.com/alerts).
- `message('')`: (string) The message of the notification.
- `url($url)`: (string) The related url of this notification.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email syed@lukonet.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Syed Irfaq R.](https://github.com/irazasyed)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

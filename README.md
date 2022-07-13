
# Laravel Pushbullet Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/manoaratefy/monolog-pushbullet.svg?style=flat-square)](https://packagist.org/packages/manoaratefy/monolog-pushbullet)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/manoaratefy/monolog-pushbullet.svg?style=flat-square)](https://packagist.org/packages/manoaratefy/monolog-pushbullet)

`manoaratefy/monolog-pushbullet` is a laravel package providing a logging handler to send logs to Pushbullet.

## Installation

You can install the package via composer:

``` bash
composer require manoaratefy/monolog-pushbullet
```

## Setup

### Get access token from Pushbullet

You will need an access token from a Pushbullet account.

### Add/edit your Laravel logging channel

You must add a new channel or edit an existing channel. This will be done into your `config/logging.php` file:

```php
// config/logging.php
'channels' => [
    //...
    'pushbullet' => [
        'driver' => 'monolog',
        'level' => env('LOG_LEVEL', 'debug'),
        'handler' => \Manoaratefy\MonologPushbullet\LogHandler::class,
        'with' => [
            'title'       => env('PUSHBULLET_NOTIFICATION_TITLE'),
            'accessToken' => env('PUSHBULLET_ACCESSTOKEN'),
            'emails'      => env('PUSHBULLET_TARGET'),
        ],        
    ],
];
```

You can then provide the settings in your `.env` file:

```
PUSHBULLET_NOTIFICATION_TITLE="Notification from MyApp"
PUSHBULLET_ACCESSTOKEN="xxxxxxxxxxxx"
PUSHBULLET_TARGET="my-pushbullet@email-account.com"
```

You can provide multiple email accounts by separating them with a comma (`,`) or by providing an array:
```php
// config/logging.php
'channels' => [
    //...
    'pushbullet' => [
        'driver' => 'monolog',
        'level' => env('LOG_LEVEL', 'debug'),
        'handler' => \Manoaratefy\MonologPushbullet\LogHandler::class,
        'with' => [
            'title'       => env('PUSHBULLET_NOTIFICATION_TITLE'),
            'accessToken' => env('PUSHBULLET_ACCESSTOKEN'),
            'emails'      => [
                'email1@example.com',
                'email2@example.com',
            ],
        ],        
    ],
];
```

## Credits

- Got some ideas from [marvinlabs/laravel-discord-logger](https://github.com/marvinlabs/laravel-discord-logger)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
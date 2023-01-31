<p align="center">
    <img height="200" src="https://www.camoo.cm/img/home1_bg.png"  alt="logo"/>
</p>

<p align="center">
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/license" alt="License"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/require/php" alt="Dependents"></a>
</p>

## Introduction

This is a package for Laravel applications which enables you to send notifications through Camoo SMS Channel.

The package uses <a href="https://www.camoo.cm/bulk-sms">Camoo SMS Service</a> to perform SMS dispatching.

## Installation

This package can be installed via composer. Just type :

```bash
composer require undjike/camoo-laravel-notification-channel
```

## Usage

After installation, configure your services in `congig/services.php` by adding :

```php
<?php

return [
    //...

    'camoo' => [
        'key' => env('CAMOO_API_KEY'), // Your credentials 
        'secret' => env('CAMOO_SECRET_KEY')
    ],
];
```

Once this is done, you can create your notification as usual.

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Undjike\CamooNotificationChannel\CamooChannel;
use Undjike\CamooNotificationChannel\CamooMessage;

class CamooNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CamooChannel::class]; // or return 'camoo';
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toCamoo($notifiable)
    {
        return CamooMessage::create()
            ->body('Type here you message content...')
            ->sender('Brand name');
        // or return 'Type here you message content...';
    }
}

```

To get this stuff completely working, you need to add this
to your notifiable model.


```php
    /**
     * Attribute to use when addressing Camoo SMS notification
     *
     * @returns string|array
     */
    public function routeNotificationForCamoo()
    {
        return $this->phone_number; // Can be a string or an array of valid phone numbers
    }
```

Enjoy !!!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

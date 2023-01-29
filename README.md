<p align="center"><img src="https://api-public.ekotech.cm/assets/images/logo.png" alt="logo"></p>

<p align="center">
<a href="https://packagist.org/packages/undjike/ekosms-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/ekosms-laravel-notification-channel/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/undjike/ekosms-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/ekosms-laravel-notification-channel/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/undjike/ekosms-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/ekosms-laravel-notification-channel/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/undjike/ekosms-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/ekosms-laravel-notification-channel/dependents.svg" alt="Dependents"></a>
</p>

## Introduction

This is a package for Laravel Applications which enables you to send notifications through EkoSMS Channel.

The package uses <a href="https://api-public.ekotech.cm/documentation/">EkoSms Service</a> to perform SMS dispatching.

## Installation

This package can be installed via composer. Just type :

```bash
composer require undjike/ekosms-laravel-notification-channel
```

## Usage

After installation, configure your services in `congig/services.php` by adding :

```php
<?php

return [
    //...

    'ekosms' => [
        'username' => env('EKOSMS_USERNAME'), // You can type in directly your credentials 
        'password' => env('EKOSMS_PASSWORD')
    ],
];
```

Once this is done, you can create your notification as usual.

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Undjike\EkoSmsNotificationChannel\CamooChannel;
use Undjike\EkoSmsNotificationChannel\EkoSmsMessage;

class EkoSmsNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CamooChannel::class]; // or return 'ekosms';
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toEkoSms($notifiable)
    {
        return EkoSmsMessage::create()
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
     * Attribute to use when addressing EkoSMS notification
     *
     * @returns string|array
     */
    public function routeNotificationForEkoSms()
    {
        return $this->phone_number; // Can be a string or an array of valid phone numbers
    }
```

Enjoy !!!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

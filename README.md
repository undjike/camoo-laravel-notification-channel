<p align="center">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="10 2 153.7 33" style="enable-background:new 0 0 153.7 33;" xml:space="preserve" class="hk_svg">
        <style type="text/css">
            .st0{fill:#ff0000;}
        </style>
        <g xmlns="http://www.w3.org/2000/svg" transform="translate(0.000000,49.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
            <path class="st0" d="M482 429 c-54 -27 -84 -70 -90 -128 -3 -40 0 -52 22 -78 36 -42 75 -56 145 -51 63 4 121 32 103 50 -7 7 -26 5 -60 -6 -132 -44 -228 60 -139 149 46 46 102 62 158 44 59 -19 80 -59 52 -98 -11 -14 -27 -27 -36 -29 -15 -3 -15 1 -3 42 l14 46 -72 0 c-80 0 -110 -14 -120 -55 -4 -14 -2 -34 4 -44 9 -17 22 -20 109 -20 93 -1 100 1 125 26 28 28 36 86 15 125 -26 49 -151 64 -227 27z"></path>
            <path d="M175 289 c-49 -28 -60 -77 -23 -103 31 -22 210 -23 228 -1 11 13 2 15 -73 15 -47 0 -88 4 -91 9 -4 5 -1 22 4 36 10 26 11 27 29 11 11 -10 31 -16 48 -14 22 2 28 8 28 28 0 24 -3 25 -65 27 -36 2 -74 -2 -85 -8z"></path>
            <path d="M736 242 c-9 -32 -16 -61 -16 -65 0 -17 64 -5 94 18 l33 25 -5 -25 c-4 -22 -1 -25 25 -25 17 0 43 12 64 29 l35 29 -1 -27 c0 -26 1 -26 69 -26 47 0 71 4 74 13 2 8 -8 12 -32 12 -20 0 -36 2 -36 4 0 2 6 22 14 44 8 22 12 43 9 46 -14 13 -62 5 -87 -15 -26 -20 -27 -20 -24 -3 5 31 -46 30 -93 -1 l-40 -26 7 26 c6 24 4 25 -34 25 l-39 0 -17 -58z"></path>
            <path d="M1145 288 c-27 -15 -35 -28 -35 -60 0 -36 34 -58 91 -58 62 0 103 30 97 71 -4 26 -1 29 22 29 24 0 26 -3 22 -34 -5 -44 25 -66 89 -66 62 0 103 30 97 71 l-5 29 73 0 c51 0 75 4 84 15 11 13 -18 15 -251 15 -178 -1 -271 -4 -284 -12z"></path>
        </g>
    </svg>
</p>

<p align="center">
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/license.svg" alt="License"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/undjike/camoo-laravel-notification-channel"><img src="https://poser.pugx.org/undjike/camoo-laravel-notification-channel/dependents.svg" alt="Dependents"></a>
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

<?php

namespace Undjike\CamooNotificationChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class CamooServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @noinspection PhpUnusedParameterInspection
     */
    public function register(): void
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('camoo', function ($app) {
                return new CamooChannel();
            });
        });
    }
}

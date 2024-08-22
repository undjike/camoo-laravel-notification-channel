<?php

namespace Undjike\CamooNotificationChannel;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Undjike\CamooNotificationChannel\Exceptions\CouldNotSendNotification;
use Undjike\CamooNotificationChannel\Requests\SendMessageRequest;

class CamooChannel
{
    /**
     * Send the given notification.
     *
     * @param $notifiable
     * @param Notification $notification
     *
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): mixed
    {
        $recipient = match (true) {
            is_string($notifiable) => $notifiable,
            $notifiable instanceof AnonymousNotifiable && $notifiable->routeNotificationFor(__CLASS__) => $notifiable->routeNotificationFor(__CLASS__),
            default => $notifiable->routeNotificationFor('camoo')
        };

        if (! $recipient) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Your notifiable instance does not have function routeNotificationForCamoo.'
            );
        }

        if (! method_exists($notification, 'toCamoo')) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'You need to define the toCamoo method on your notification for it to be sent.'
            );
        }

        $message = $notification->toCamoo($notifiable);

        if (is_string($message)) {
            $content = trim($message);
            $message = CamooMessage::create()->body($content);
        }

        if (! $message instanceof CamooMessage) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Expected string or CamooMessage instance as the return type of toCamoo.'
            );
        }

        if (empty(trim($message->getBody()))) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Can\'t send a message with an empty body.'
            );
        }

        if (! is_array($recipient) && ! is_string($recipient)) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Expected string or array as recipient.'
            );
        }

        return SendMessageRequest::execute($message, $recipient);
    }
}

<?php

namespace Undjike\CamooNotificationChannel;

use Illuminate\Notifications\Notification;
use Undjike\CamooNotificationChannel\Exceptions\CouldNotSendNotification;
use Undjike\CamooNotificationChannel\Requests\SendMessageRequest;

class CamooChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return array
     * @throws CouldNotSendNotification
     */
    public function send(mixed $notifiable, Notification $notification): mixed
    {
        if (! $recipient = $notifiable->routeNotificationFor('Camoo')) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Your notifiable instance does not have function routeNotificationForCamoo.'
            );
        }

        if (! method_exists($notification, 'toCamoo')) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Your need to define the toCamoo method on your notification for it to be sent.'
            );
        }

        $message = $notification->toCamoo($notifiable);

        if (is_string($message)) {
            $content = trim($message);
            $message = CamooMessage::create()->body($content);
        }

        if (! $message instanceof CamooMessage) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Required string or CamooMessage instance as the return type of toCamoo.'
            );
        }

        if (empty(trim($message->getBody()))) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Can\'t send a message with an empty body.'
            );
        }

        if (is_string($recipient)) {
            $recipient = [$recipient];
        }

        if (! is_array($recipient)) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Expected string or array as recipient.'
            );
        }

        return SendMessageRequest::execute($message, $recipient);
    }
}

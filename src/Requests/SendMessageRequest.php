<?php

namespace Undjike\CamooNotificationChannel\Requests;

use Camoo\Sms\Message;
use Undjike\CamooNotificationChannel\CamooMessage;
use Undjike\CamooNotificationChannel\Exceptions\CouldNotSendNotification;

class SendMessageRequest
{
    /**
     * @param CamooMessage $message
     * @param array $addressees
     * @param array|null $auth
     *
     * @return mixed
     * @throws CouldNotSendNotification
     * @noinspection PhpUndefinedFunctionInspection
     */
    public static function execute(CamooMessage $message, array $addressees, array $auth = null): mixed
    {
        $auth ??= [
            'key' => config('services.camoo.key'),
            'secret' => config('services.camoo.secret')
        ];

        $client = Message::create($auth['key'], $auth['secret']);

        if (! $client) {
            throw CouldNotSendNotification::camooRespondedWithAnError(
                'Error occurred instantiating the service.'
            );
        }

        $client->from = $message->getSender();
        $client->to = $addressees;
        $client->message = $message->getBody();

        if ($message->isClassic()) {
            $client->route = 'classic';
        }

        if ($message->isEncrypted()) {
            $client->encrypt = true;
        }

        if ($message->isBulkSending()) {
            return $client->sendBulk();
        }

        return $client->send();
    }
}

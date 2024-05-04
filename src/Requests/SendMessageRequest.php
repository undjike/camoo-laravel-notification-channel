<?php

namespace Undjike\CamooNotificationChannel\Requests;

use Camoo\Sms\Message;
use Undjike\CamooNotificationChannel\CamooMessage;
use Undjike\CamooNotificationChannel\Exceptions\CouldNotSendNotification;

class SendMessageRequest
{
    /**
     * @param CamooMessage $message
     * @param array|string $addressee
     * @param array|null $auth
     *
     * @return mixed
     * @throws CouldNotSendNotification
     * @noinspection PhpUndefinedFunctionInspection
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public static function execute(CamooMessage $message, array|string $addressee, array $auth = null): mixed
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
        $client->to = $addressee;
        $client->message = $message->getBody();

        if (! empty($url = $message->getNotifyUrl())) {
            $client->notify_url = $url;
        }

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

<?php

namespace Undjike\CamooNotificationChannel\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function camooRespondedWithAnError($response): CouldNotSendNotification
    {
        return new static("Camoo service responded with an error: $response");
    }
}

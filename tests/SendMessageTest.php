<?php

namespace Undjike\CamooNotificationChannel\Tests;

use Camoo\Sms\Message;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNull;

class SendMessageTest extends TestCase
{
    public function test_send_message_success(): void
    {
        $client = Message::create(
            'api_key',
            'api_secret'
        );

        $client->from = 'InSave';
        $client->to = '+237697777205';

        $client->message = "New test of pull request!";

        assertNotEmpty($client->send()->getId());
    }

    public function test_wrong_credentials_error(): void
    {
        $client = Message::create(
            'wrong api key',
            'wrong api secret'
        );

        $client->from = 'App Brand';
        $client->to = '+237697777205';

        $client->message = "Really going well!";

        assertNull($client->send()->getId());
    }
}

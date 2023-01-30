<?php

namespace Undjike\CamooNotificationChannel;

class CamooMessage
{
    /**
     * Body of the message
     *
     * @var string
     */
    protected string $body;

    /**
     * Brand name of the message
     *
     * @var string
     */
    protected string $brand = 'App Brand';

    /**
     * Send in bulk
     *
     * @var bool
     */
    protected bool $batchSending = false;

    /**
     * Classic message
     *
     * @var bool
     */
    protected bool $sendAsClassicMessage = false;

    /**
     * Encrypt the message
     *
     * @var bool
     */
    protected bool $encrypt = false;

    /**
     * CamooMessage constructor.
     *
     * @param string $body
     */
    public function __construct(string $body = '')
    {
        $this->body($body);
    }

    /**
     * CleanSmsMessage pseudo-constructor.
     *
     * @param string $body
     *
     * @return CamooMessage
     */
    public static function create(string $body = ''): CamooMessage
    {
        return new static($body);
    }

    /**
     * Set message body
     *
     * @param string $body
     *
     * @return CamooMessage
     */
    public function body(string $body): CamooMessage
    {
        $this->body = trim($body);
        return $this;
    }

    /**
     * Get message body
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set message sender
     *
     * @param string $brand
     *
     * @return CamooMessage
     */
    public function sender(string $brand): CamooMessage
    {
        $this->brand = trim($brand);
        return $this;
    }

    /**
     * Get message sender
     *
     * @return string
     */
    public function getSender(): string
    {
        return $this->brand;
    }

    /**
     * Whether the message is sent in bulk to several addressees
     *
     * @param bool $sendBulk
     *
     * @return CamooMessage
     */
    public function bulkSending(bool $sendBulk = true): CamooMessage
    {
        $this->batchSending = $sendBulk;
        return $this;
    }

    /**
     * Whether the message is sent in bulk to several addressees
     *
     * @return bool
     */
    public function isBulkSending(): bool
    {
        return $this->batchSending;
    }

    /**
     * Whether the message should be encrypted
     *
     * @param bool $encrypt
     *
     * @return CamooMessage
     */
    public function shouldEncrypt(bool $encrypt = true): CamooMessage
    {
        $this->encrypt = $encrypt;
        return $this;
    }

    /**
     * Whether the message should be encrypted
     *
     * @return bool
     */
    public function isEncrypted(): bool
    {
        return $this->encrypt;
    }

    /**
     * Whether the message should be sent as classic messages (no custom sender)
     *
     * @param bool $classicMessaging
     *
     * @return CamooMessage
     */
    public function useClassic(bool $classicMessaging = true): CamooMessage
    {
        $this->sendAsClassicMessage = $classicMessaging;
        return $this;
    }

    /**
     * Whether the message should be sent as classic messages (no custom sender)
     *
     * @return bool
     */
    public function isClassic(): bool
    {
        return $this->sendAsClassicMessage;
    }
}

<?php

namespace NotificationChannels\ViberNetUa;

class ViberNetUaMessage
{
    /**
     * Message body.
     *
     * @var string
     */
    public $body;
    /**
     * @var string
     */
    public $name;

    /**
     * ViberNetUaMessage constructor.
     * @param string $name
     * @param string $body
     */
    public function __construct(string $name, string $body)
    {
        $this->body = $body;
        $this->name = $name;
    }
}

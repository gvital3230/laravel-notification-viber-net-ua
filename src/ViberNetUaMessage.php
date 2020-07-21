<?php

namespace NotificationChannels\ViberNetUa;

class ViberNetUaMessage
{
    /**
     * @var ViberNetUaMessageType
     */
    public $type;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $url_image;
    /**
     * @var string
     */
    public $button_name;
    /**
     * @var string
     */
    public $button_url;
    /**
     * @var string
     */
    public $name;

    /**
     * ViberNetUaMessage constructor.
     * @param ViberNetUaMessageType $type
     * @param string $name
     * @param string $message
     * @param string $url_image
     * @param string $button_name
     * @param string $button_url
     */
    public function __construct(
        ViberNetUaMessageType $type,
        string $name,
        string $message,
        string $url_image = '',
        string $button_name = '',
        string $button_url = ''
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->message = $message;
        $this->url_image = $url_image;
        $this->button_name = $button_name;
        $this->button_url = $button_url;
    }
}

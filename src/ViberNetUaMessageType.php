<?php


namespace NotificationChannels\ViberNetUa;


/**
 * @method static ViberNetUaMessageType TYPE_ONLY_MESSAGE()
 * @method static ViberNetUaMessageType TYPE_ONLY_IMAGE()
 * @method static ViberNetUaMessageType TYPE_ONLY_BUTTON()
 * @method static ViberNetUaMessageType TYPE_MESSAGE_AND_BUTTON()
 * @method static ViberNetUaMessageType TYPE_IMAGE_AND_BUTTON()
 * @method static ViberNetUaMessageType TYPE_MESSAGE_IMAGE_AND_BUTTON()
 */
class ViberNetUaMessageType extends \MyCLabs\Enum\Enum
{
    private const TYPE_ONLY_MESSAGE = 'ONLY_MESSAGE';
    private const TYPE_ONLY_IMAGE = 'ONLY_IMAGE';
    private const TYPE_ONLY_BUTTON = 'ONLY_BUTTON';
    private const TYPE_MESSAGE_AND_BUTTON = 'MESSAGE_AND_BUTTON';
    private const TYPE_IMAGE_AND_BUTTON = 'IMAGE_AND_BUTTON';
    private const TYPE_MESSAGE_IMAGE_AND_BUTTON = 'MESSAGE_IMAGE_AND_BUTTON';

}

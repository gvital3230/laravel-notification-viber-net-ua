<?php

namespace NotificationChannels\ViberNetUa\Exceptions;

class CouldNotSendNotification extends \Exception
{
    /**
     * Thrown when we're unable to communicate with ViberNetUa.
     *
     * @param \Exception $exception
     *
     * @return CouldNotSendNotification
     */
    public static function couldNotCommunicateWithEndPoint(\Exception $exception): self
    {
        return new static("The communication with endpoint failed. Reason: {$exception->getMessage()}", $exception->getCode(), $exception);
    }
}

<?php

namespace NotificationChannels\ViberNetUa;

use PHPUnit\Framework\TestCase;

class ViberNetUaMessageTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiate()
    {
        $instance = new ViberNetUaMessage(ViberNetUaMessageType::TYPE_ONLY_MESSAGE(), 'TEST_NAME', 'TEST_BODY');
        $this->assertInstanceOf(ViberNetUaMessage::class, $instance);
    }
}

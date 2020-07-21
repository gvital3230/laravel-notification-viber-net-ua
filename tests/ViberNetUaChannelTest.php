<?php

namespace NotificationChannels\ViberNetUa;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\ViberNetUa\Exceptions\CouldNotSendNotification;
use PHPUnit\Framework\TestCase;

class ViberNetUaChannelTest extends TestCase
{
    /**
     * @var Notification|Mockery\MockInterface
     */
    protected $testNotification;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_can_be_instantiate()
    {
        $testConfig = [
            'endpoint' => 'https://my2.viber.net.ua/api/v2/viber/dispatch',
            'token' => 'TEST_TOKEN',
            'sender' => 'TEST_SENDER',
            'debug' => false,
            'sandboxMode' => false,
        ];
        $instance = new ViberNetUaChannel(new Client, $testConfig);

        $this->assertInstanceOf(ViberNetUaChannel::class, $instance);
    }

    /** @test */
    public function it_sends_a_notification()
    {
        $testConfig = [
            'endpoint' => 'https://my2.viber.net.ua/api/v2/viber/dispatch',
            'token' => 'TEST_TOKEN',
            'sender' => 'TEST_SENDER',
            'debug' => false,
            'sandboxMode' => false,
        ];
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'status' => 'success',
            ])),
        ]);
        $handlerStack = HandlerStack::create($mock);

        $client = new Client(['handler' => $handlerStack]);
        $testChannel = new ViberNetUaChannel($client, $testConfig);

        $testChannel->send(new TestNotifiable(), new TestNotification());
        $this->assertTrue(true);//exceptions did not throw
    }

    /**
     * @test
     */
    public function it_can_handle_error_status_from_API()
    {
        $testConfig = [
            'endpoint' => 'https://my2.viber.net.ua/api/v2/viber/dispatch',
            'token' => 'TEST_TOKEN',
            'sender' => 'TEST_SENDER',
            'debug' => false,
            'sandboxMode' => false,
        ];
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'status' => 'error',
            ])),
        ]);
        $handlerStack = HandlerStack::create($mock);

        $client = new Client(['handler' => $handlerStack]);
        $testChannel = new ViberNetUaChannel($client, $testConfig);

        $this->expectException(CouldNotSendNotification::class);
        $testChannel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_do_not_invoke_api_in_sandbox_mode()
    {
        $testConfig = [
            'endpoint' => 'http://ViberNetUa.in.ua/api/wsdl.html',
            'token' => 'TEST_TOKEN',
            'sender' => 'TEST_SENDER',
            'debug' => false,
            'sandboxMode' => true,
        ];
        $testClient = Mockery::spy(Client::class);
        $testChannel = new ViberNetUaChannel($testClient, $testConfig);

        $testChannel->send(new TestNotifiable(), new TestNotification());

        $testClient->shouldNotHaveReceived('request');
        $this->assertTrue(true);//exceptions did not throw
    }
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForViberNetUa()
    {
        return 'TEST_RECIPIENT';
    }
}

class TestNotification extends Notification
{
    public function toViberNetUa($notifiable)
    {
        return new ViberNetUaMessage('TEST_BODY');
    }
}

<?php

namespace NotificationChannels\ViberNetUa;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use NotificationChannels\ViberNetUa\Exceptions\CouldNotSendNotification;

class ViberNetUaChannel
{

    /**
     * @var Client
     */
    private $client;

    /**
     * API endpoint url.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $sender;

    /**
     * Debug flag. If true, messages send/result wil be stored in Laravel log.
     *
     * @var bool
     */
    protected $debug;

    /**
     * Sandbox mode flag. If true, endpoint API will not be invoked, useful for dev purposes.
     *
     * @var bool
     */
    protected $sandboxMode;


    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->endpoint = Arr::get($config, 'endpoint');
        $this->token = Arr::get($config, 'token');
        $this->sender = Arr::get($config, 'sender');
        $this->sandboxMode = Arr::get($config, 'sandboxMode');
        $this->debug = Arr::get($config, 'debug');
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     *
     * @param Notification $notification
     * @return void
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var ViberNetUaMessage $message */
        $message = $notification->toViberNetUa($notifiable);
        if (is_string($message)) {
            $message = new ViberNetUaMessage(
                ViberNetUaMessageType::TYPE_ONLY_MESSAGE(),
                '',
                $message);
        }

        if ($this->debug) {
            Log::info('ViberNetUa sending sms - ' . print_r($message, true));
        }

        if ($this->sandboxMode) {
            return;
        }

        try {
            $json = [
                'validity' => $message->validity
            ];
            if ($message->type == ViberNetUaMessageType::TYPE_ONLY_MESSAGE()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'message' => $message->message,
                ]);
            } elseif ($message->type == ViberNetUaMessageType::TYPE_ONLY_IMAGE()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'url_image' => $message->url_image,
                ]);
            } elseif ($message->type == ViberNetUaMessageType::TYPE_ONLY_BUTTON()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'button_name' => $message->button_name,
                    'button_url' => $message->button_url,
                ]);
            } elseif ($message->type == ViberNetUaMessageType::TYPE_MESSAGE_AND_BUTTON()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'message' => $message->message,
                    'button_name' => $message->button_name,
                    'button_url' => $message->button_url,
                ]);
            } elseif ($message->type == ViberNetUaMessageType::TYPE_IMAGE_AND_BUTTON()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'url_image' => $message->url_image,
                    'button_name' => $message->button_name,
                    'button_url' => $message->button_url,
                ]);
            } elseif ($message->type == ViberNetUaMessageType::TYPE_MESSAGE_IMAGE_AND_BUTTON()) {
                $json = array_merge($json, [
                    'name' => $message->name,
                    'recipients' => $notifiable->routeNotificationFor('vibernetua'),
                    'sender' => $this->sender,
                    'message' => $message->message,
                    'url_image' => $message->url_image,
                    'button_name' => $message->button_name,
                    'button_url' => $message->button_url,
                ]);
            }
            /** @var Response $response */
            $response = $this->client->request('POST', $this->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
//                    'Accept' => 'application/json',
                ],
                'json' => $json
            ]);

            $result = (array)\GuzzleHttp\json_decode($response->getBody());

            if ($this->debug) {
                Log::info('ViberNetUa send result code - ' . $response->getStatusCode() . ' with body' . $response->getBody());
            }

            if (Arr::get($result, 'status') !== 'success') {
                throw new \Exception(print_r($result, true));
            }

        } catch (\Throwable $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithEndPoint($exception);
        }


    }
}

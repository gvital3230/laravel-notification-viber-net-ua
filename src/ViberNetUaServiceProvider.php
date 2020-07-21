<?php

namespace NotificationChannels\ViberNetUa;

use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class ViberNetUaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('vibernetua', function ($app) {
                return new ViberNetUaChannel(
                    new Client(),
                    config('services.vibernetua')
                );
            });
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}

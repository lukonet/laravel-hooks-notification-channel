<?php

namespace NotificationChannels\Hooks;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class HooksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(HooksChannel::class)
            ->needs(Hooks::class)
            ->give(function () {
                $hooksKey = config('services.hooks.key');

                return new Hooks($hooksKey, new HttpClient());
            });
    }
}

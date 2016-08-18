<?php

namespace NotificationChannels\Hooks;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use NotificationChannels\Hooks\Exceptions\CouldNotSendNotification;

class Hooks
{
    /** @var HttpClient HTTP Client */
    protected $http;

    /** @var null|string Hooks API Key */
    protected $key = null;

    /**
     * @param null            $key        API Key
     * @param HttpClient|null $httpClient
     */
    public function __construct($key = null, HttpClient $httpClient = null)
    {
        $this->key = $key;

        $this->http = $httpClient;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }

    /**
     * Send Notification.
     *
     * @param array|\JsonSerializable $fields
     *
     * @var param $alertId
     * @var param $message
     * @var param $url
     *
     * @throws CouldNotSendNotification
     *
     * @return mixed
     */
    public function send($fields)
    {
        return $this->api($fields);
    }

    /**
     * Send an API request and return response.
     *
     * @param $fields
     *
     * @throws CouldNotSendNotification
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function api($fields)
    {
        if (empty($this->key)) {
            throw CouldNotSendNotification::hooksApiKeyNotProvided('You must provide your Hooks API key to send any notifications.');
        }

        $apiUrl = 'https://api.gethooksapp.com/v1/push/'.$fields['alertId'];
        unset($fields['alertId']);

        try {
            return $this->httpClient()->post($apiUrl, [
                RequestOptions::JSON    => $fields,
                RequestOptions::HEADERS => ['Hooks-Authorization' => $this->key],
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::hooksRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithHooks($exception);
        }
    }
}

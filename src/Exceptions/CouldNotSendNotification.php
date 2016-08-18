<?php

namespace NotificationChannels\Hooks\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends \Exception
{
    /**
     * Thrown when there's a bad request and an error is responded.
     *
     * @param ClientException $exception
     *
     * @return static
     */
    public static function hooksRespondedWithAnError(ClientException $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();
        $result = json_decode($exception->getResponse()->getBody());

        return new static("Hooks API responded with an error `{$statusCode} - {$result->status} : {$result->msg}`");
    }

    /**
     * Thrown when there's no api key provided.
     *
     * @param string $message
     *
     * @return static
     */
    public static function hooksApiKeyNotProvided($message)
    {
        return new static($message);
    }

    /**
     * Thrown when we're unable to communicate with Hooks API.
     *
     * @param \Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithHooks(Exception $exception)
    {
        return new static('The communication with Hooks API failed. Reason: '.$exception->getMessage());
    }

    public static function alertIdNotProvided()
    {
        return new static('Alert ID for this notification was not provided.');
    }
}


<?php

namespace NotificationChannels\Hooks;

class HooksMessage implements \JsonSerializable
{
    /** @var integer Alert ID. */
    public $alertId;

    /** @var string Notification Message. */
    public $message;

    /** @var string Notification URL. */
    public $url;

    /**
     * @param integer $alertId
     * @param string  $message
     * @param string  $url
     *
     * @return static
     */
    public static function create($alertId = null, $message = '', $url = '')
    {
        return new static($alertId, $message, $url);
    }

    /**
     * @param integer $alertId
     * @param string  $message
     * @param string  $url
     */
    public function __construct($alertId = null, $message = '', $url = '')
    {
        $this->alertId = $alertId;
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Alert ID associated with this notification.
     *
     * @param integer $alertId
     *
     * @return $this
     */
    public function alertId($alertId)
    {
        $this->alertId = $alertId;

        return $this;
    }

    /**
     * Notification message.
     *
     * @param $message
     *
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Notification Url.
     *
     * @param string $url
     *
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Determine if alert id is not given.
     *
     * @return bool
     */
    public function alertIdNotGiven()
    {
        return !isset($this->alertId);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Returns payload.
     *
     * @return array
     */
    public function toArray()
    {
        $payload = [];
        $payload['alertId'] = $this->alertId;
        $payload['message'] = $this->message;

        if (isset($this->url)) {
            $payload['url'] = $this->url;
        }

        return $payload;
    }
}

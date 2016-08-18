<?php

namespace NotificationChannels\Hooks;

use NotificationChannels\Hooks\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class HooksChannel
{
    /**
     * @var Hooks
     */
    protected $hooks;

    public function __construct(Hooks $hooks)
    {
        $this->hooks = $hooks;
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Hooks\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toHooks($notifiable);

        if ($message->alertIdNotGiven()) {
            if (! $alertId = $notifiable->routeNotificationFor('hooks')) {
                throw CouldNotSendNotification::alertIdNotProvided();
            }

            $message->alertId($alertId);
        }

        $this->hooks->send($message->toArray());
    }
}

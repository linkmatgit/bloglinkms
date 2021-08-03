<?php

namespace App\Domain\Notification\Event;

use App\Domain\Notification\Entity\Notification;

class NotificationReadEvent
{
    private Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}

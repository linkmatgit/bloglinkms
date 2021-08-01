<?php


namespace App\Domain\Notification\Subscriber;


use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Notification\Service\NotificationService;
use App\Infrastructure\Mailing\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationModSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private NotificationService $notificationService
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ModCreatedEvent::class => 'onCreate'
        ];
    }



}
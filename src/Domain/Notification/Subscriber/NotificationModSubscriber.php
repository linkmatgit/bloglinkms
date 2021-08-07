<?php


namespace App\Domain\Notification\Subscriber;

use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Service\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationModSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private NotificationService $notificationService,
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ModCreatedEvent::class => 'onCreate'
        ];
    }


    public function onCreate(ModCreatedEvent $e)
    {
        $userName = htmlentities($e->getMod()->getAuthor()->getName());
        $name = htmlentities($e->getMod()->getTitle());
        return   $this->notificationService->notifyChannel(
            'admin',
            $userName . " a poster un mod "  . $name,
        );
    }
}

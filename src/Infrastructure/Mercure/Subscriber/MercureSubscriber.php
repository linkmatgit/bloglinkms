<?php

namespace App\Infrastructure\Mercure\Subscriber;

use App\Domain\Auth\User;
use App\Domain\Notification\Event\NotificationCreatedEvent;
use App\Domain\Notification\Event\NotificationReadEvent;
use App\Infrastructure\Queue\EnqueueMethod;
use App\Infrastructure\Queue\Handler\ServiceMethodMessageHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class MercureSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private HubInterface $publisher;

    private EnqueueMethod $enqueue;

    public function __construct(SerializerInterface $serializer, HubInterface $publisher, EnqueueMethod $enqueue)
    {
        $this->serializer = $serializer;
        $this->publisher = $publisher;
        $this->enqueue = $enqueue;
    }

    public static function getSubscribedEvents(): array
    {
        return [
           NotificationCreatedEvent::class => 'publishNotification',
        ];
    }

    public function publishNotification(NotificationCreatedEvent $event): void
    {

        $notification = $event->getNotification();
        $channel = $notification->getChannel();
        if ('public' === $channel && $notification->getUser() instanceof User) {
            $channel = 'user/'.$notification->getUser()->getId();
        }
        $update = new Update("/notifications/$channel", $this->serializer->serialize([
            'type' => 'notification',
            'data' => $notification,
        ], 'json', [
            'groups' => ['read:notification'],
            'iri' => false,
        ]), true);
        $this->enqueue->enqueue(ServiceMethodMessageHandler::class, '__invoke', [$update]);

    }

    public function onNotificationRead(NotificationReadEvent $event): void
    {
        $user = $event->getUser();
        $update = new Update(
            "/notifications/user/{$user->getId()}",
            '{"type": "markAsRead"}',
            true
        );
        $this->enqueue->enqueue(ServiceMethodMessageHandler::class, '__invoke', [$update]);
    }
}

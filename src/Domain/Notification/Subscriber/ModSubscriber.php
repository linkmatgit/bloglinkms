<?php

namespace App\Domain\Notification\Subscriber;


use App\Domain\Mods\Event\ModCreatedEvent;
use App\Infrastructure\Queue\EnqueueMethod;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ModSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
       return [
           ModCreatedEvent::class => 'onCreate'
       ];
    }
}
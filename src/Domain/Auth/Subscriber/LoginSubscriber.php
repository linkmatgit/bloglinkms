<?php

namespace App\Domain\Auth\Subscriber;

use App\Domain\Auth\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class LoginSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private EntityManagerInterface $em,
        private ?UserInterface $user = null
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            InteractiveLoginEvent::class => 'onSuccesLogin',
            LoginFailureEvent::class => 'onFailureLogin'

        ];
    }
    public function onSuccesLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        $event->getRequest()->getClientIp();
        if ($user instanceof  User) {
            $ip = $event->getRequest()->getClientIp();
            if ($ip !== $user->getLastLoginIP()) {
                $user->setLastLoginIP($ip);
            }
            $user->setLastLoginAt(new DateTime());
            $this->em->flush();
        }
    }

    public function onFailureLogin():void
    {
    }
}

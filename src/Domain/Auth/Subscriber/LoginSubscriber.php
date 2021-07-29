<?php


namespace App\Domain\Auth\Subscriber;


use App\Domain\Auth\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class LoginSubscriber implements EventSubscriberInterface
{


    public function __construct(private EntityManagerInterface $em)
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            //AuthenticationEvents::AUTHENTICATION_FAILURE  => 'onFailureLogin',
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSuccesLogin',
            LoginFailureEvent::class => 'onFailureLogin'

        ];
    }
    public function onSuccesLogin() {

    }
    public function onFailureLogin() {
        dd('bye');
    }
}
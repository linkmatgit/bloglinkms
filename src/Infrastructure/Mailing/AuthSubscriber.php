<?php

declare(strict_types=1);

namespace App\Infrastructure\Mailing;

use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;

class AuthSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private EmailVerifier $emailVerifier,
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            UserCreatedEvent::class => 'onRegister'
        ];
    }
    public function onRegister(UserCreatedEvent $event): void
    {
        $this->emailVerifier->sendEmailConfirmation('verify_email', $event->getUser(),
            (new TemplatedEmail())
                ->from(new Address('no-reply@linkmat.com', 'Linkmat.Com'))
                ->to($event->getUser()->getEmail())
                ->subject('Linkmat | Confirmation du compte')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }

}

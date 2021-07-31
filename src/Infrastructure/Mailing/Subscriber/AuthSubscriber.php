<?php

declare(strict_types=1);

namespace App\Infrastructure\Mailing\Subscriber;

use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\Event\UserVerifiedEvent;
use App\Infrastructure\Mailing\Mailer;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;


class AuthSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private EmailVerifier $emailVerifier,
        private Mailer $mailer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onRegister',
            UserVerifiedEvent::class => 'onVerified'
        ];
    }
    public function onRegister(UserCreatedEvent $event): void
    {
        $email = $this->mailer->createEmail('mails/auth/register.twig', [
            'user' => $event->getUser(),
        ])
            ->to($event->getUser()->getEmail())
            ->subject('Linkmat | Confirmation du compte');
            $this->mailer->send($email);
    }

    public function onVerified(UserVerifiedEvent $event):void
    {
        $this->emailVerifier->sendEmailConfirmation(
            'verify_email',
            $event->getUser(),
            (new TemplatedEmail())
                ->from(new Address('no-reply@linkmat.com', 'Linkmat.Com'))
                ->to($event->getUser()->getEmail())
                ->subject('Linkmat | Votre Compte a été confirmée')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }
}

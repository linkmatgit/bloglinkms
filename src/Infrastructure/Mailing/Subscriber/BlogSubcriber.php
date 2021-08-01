<?php

declare(strict_types=1);

namespace App\Infrastructure\Mailing\Subscriber;

use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\Event\UserVerifiedEvent;
use App\Domain\Auth\User;
use App\Domain\Blog\Event\PostCreatedEvent;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints\Timezone;

class BlogSubcriber implements EventSubscriberInterface
{

    const  ADMIN_EMAIL = 'noreply@linkmat.conm';

    public function __construct(
        private \App\Infrastructure\Mailing\Mailer $mailer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostCreatedEvent::class => 'onCreate'
        ];
    }
    public function onCreate(PostCreatedEvent $event): void
    {
        $email = $this->mailer->createEmail('mails/auth/register.twig', [
            'user' => $event->getPost()->getAuthor(),
        ])
            ->to($event->getPost()->getAuthor()->getEmail())
            ->subject('Linkmat | Votre Mod a ete soumis')
        ;
        $this->mailer->send($email);
    }


}

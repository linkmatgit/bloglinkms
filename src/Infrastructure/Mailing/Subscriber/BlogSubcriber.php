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
        private MailerInterface $mailer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostCreatedEvent::class => 'onCreate'
        ];
    }
    public function onCreate(PostCreatedEvent $event): void
    {       $message = <<<TEXT
Voici le Contenu:
 
 {$event->getPost()->getContent()}
 
 
Crée par: {$event->getPost()->getAuthor()->getName()}
TEXT;
        $email = new Email();
        $email->from(self::ADMIN_EMAIL);
        $email->to(self::ADMIN_EMAIL);
        $email->subject("L'article {$event->getPost()->getTitle()} est pret pour la publication ");
        $email->text($message);

        $this->mailer->send($email);
    }


}

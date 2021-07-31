<?php

namespace App\Infrastructure\Queue\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class FailedJobsSubscriber implements EventSubscriberInterface
{
    const FROM = 'linkmat.com';
    const  TO = 'administrateur@beaugoss.com';

    public function __construct(private MailerInterface $mailer)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            WorkerMessageFailedEvent::class => 'onMessageFailed'
        ];
    }

    /**
     * @param WorkerMessageFailedEvent $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function onMessageFailed(WorkerMessageFailedEvent $event): void
    {

        $message = get_class($event->getEnvelope()->getMessage());
        $throw = $event->getThrowable()->getTraceAsString();
            $this->mailer->send($this->email($message, $throw));
    }

    private function email(string $error, string $trace): Email
    {
        $message =  <<<TEXT
Une Erreur est survenue lors du traitement de la tache {$error}

Voici la trace de l'erreur: 
{$trace}
TEXT;

        return  (new Email())->from(self::FROM)
            ->to(self::TO)
            ->text("Une Erreur est survenue lors du traitement de la tache {$error}");
    }
}

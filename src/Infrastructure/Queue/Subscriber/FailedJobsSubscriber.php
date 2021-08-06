<?php

namespace App\Infrastructure\Queue\Subscriber;

use App\Domain\Notification\Service\NotificationService;
use App\Infrastructure\Queue\FailedJob;
use App\Infrastructure\Queue\Message\ServiceMethodMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineReceivedStamp;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;

class FailedJobsSubscriber implements EventSubscriberInterface
{
    const FROM = 'linkmat@linkmat.com';
    const  TO = 'administrateur@beaugoss.com';

    public function __construct(
        private MailerInterface $mailer,
        private NotificationService $notificationService
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            WorkerMessageFailedEvent::class => 'onMessageFailed'
        ];
    }

    /**
     * @param WorkerMessageFailedEvent $event
     * @throws TransportExceptionInterface
     */
    public function onMessageFailed(WorkerMessageFailedEvent $event): void
    {
        $message = $event->getEnvelope()->getMessage();
        // Si le message qui a échoué, est une notification, on ne demande pas une nouvelle notification (cela créerait une boucle infinie)
        if ($message instanceof ServiceMethodMessage &&
            HubInterface::class === $message->getServiceName()
        ) {
            return;
        }

        // On reçoit une enveloppe de tâche "classique" et on veut la faire passer pour une tâche en échec
        // On lui passe un RedeliveryStamp (pour faire croire que la tâche a déjà été relancé)
        $redeliveryStamp = new RedeliveryStamp(1, $event->getThrowable()->getMessage());
        // On lui passe un DoctrineReceivedStamp (pour faire croire que la tâche provient de doctrine)
        $doctrineStamp = new DoctrineReceivedStamp('1');
        $enveloppe = $event->getEnvelope()->with($redeliveryStamp)->with($doctrineStamp);
        $job = new FailedJob($enveloppe);
        $this->notificationService->notifyChannel('admin', "Une tâche de la file d'attente a échoué", $job);
    }
}

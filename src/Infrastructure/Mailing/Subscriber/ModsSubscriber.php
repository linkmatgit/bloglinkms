<?php


namespace App\Infrastructure\Mailing\Subscriber;


use App\Domain\Mods\Event\ModCreatedEvent;
use App\Infrastructure\Mailing\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ModsSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private Mailer $mailer
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ModCreatedEvent::class => 'onCreate'
        ];
    }

    public function onCreate(ModCreatedEvent $event) {

        $email = $this->mailer->createEmail('mails/mods/create.twig', [
            'mods' => $event->getMod(),
        ])
            ->to($event->getMod()->getAuthor()->getEmail())
            ->subject('Linkmat | Votre Mod a ete soumis')
        ;
        $this->mailer->send($email);
    }

}
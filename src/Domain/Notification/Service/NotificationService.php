<?php

namespace App\Domain\Notification\Service;


use App\Domain\Auth\User;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Event\NotificationCreatedEvent;
use App\Domain\Notification\Repository\NotificationRepository;
use App\Http\Encoder\PathEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class NotificationService
{

    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $em,
        private EventDispatcherInterface $dispatcher,
        private Security $security
    ) {
    }


    public function getChannelsForUser(User $user): array
    {
        $channels = [
            'user/'.$user->getId(),
            'public',
        ];

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $channels[] = 'admin';
        }

        return $channels;
    }

    public function notifyUser(User $user, string $message, object $entity): Notification
    {
        /** @var string $url */
        $url = $this->serializer->serialize($entity, PathEncoder::FORMAT);
        /** @var NotificationRepository $repository */
        $repository = $this->em->getRepository(Notification::class);
        $notification = (new Notification())
            ->setMessage($message)
            ->setUrl($url)
            ->setTarget($this->getHashForEntity($entity))
            ->setCreatedAt(new \DateTime())
            ->setUser($user);
        $repository->persistOrUpdate($notification);
        $this->em->flush();
        $this->dispatcher->dispatch(new NotificationCreatedEvent($notification));

        return $notification;
    }

    public function notifyChannel(string $channel, string $message, mixed $entity = null): Notification
    {
        /** @var string $url */
        $url = $entity ? $this->serializer->serialize($entity, PathEncoder::FORMAT) : null;
        $notification = (new Notification())
            ->setMessage($message)
            ->setUrl($url)
            ->setTarget($entity ? $this->getHashForEntity($entity) : null)
            ->setCreatedAt(new \DateTime())
            ->setChanel($channel);
        $this->em->persist($notification);
        $this->em->flush();
        $this->dispatcher->dispatch(new NotificationCreatedEvent($notification));

        return $notification;
    }


    private function getHashForEntity(object $entity): string
    {
        $hash = get_class($entity);
        if (method_exists($entity, 'getId')) {
            $hash .= '::'.(string) $entity->getId();
        }

        return $hash;
    }

}
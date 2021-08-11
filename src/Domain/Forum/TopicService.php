<?php

namespace App\Domain\Forum;

use App\Domain\Auth\User;
use App\Domain\Forum\Entity\Message;
use App\Domain\Forum\Entity\Topic;
use App\Domain\Forum\Event\PreTopicCreatedEvent;
use App\Domain\Forum\Event\TopicCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class TopicService
{


    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em
    ) {
    }

    /**
     * Crée un nouveau sujet.
     */
    public function createTopic(Topic $topic): void
    {
        $topic->setCreatedAt(new \DateTime());
        $topic->setUpdatedAt(new \DateTime());
        $this->dispatcher->dispatch(new PreTopicCreatedEvent($topic));
        $this->em->persist($topic);
        $this->em->flush();
        $this->dispatcher->dispatch(new TopicCreatedEvent($topic));
    }

    /**
     * Met à jour un sujet.
     */
    public function updateTopic(Topic $topic): void
    {
        $topic->setUpdatedAt(new \DateTime());
        $this->em->flush();
    }
}

<?php

namespace App\Domain\Forum\Event;

class PreTopicCreatedEvent
{

    /**
     * @param Topic $topic
     */
    public function __construct(\App\Domain\Forum\Entity\Topic $topic)
    {
    }
}
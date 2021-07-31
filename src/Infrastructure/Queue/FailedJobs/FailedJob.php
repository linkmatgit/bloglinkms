<?php

namespace App\Infrastructure\Queue\FailedJobs;


use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\ErrorDetailsStamp;


class FailedJob
{
    public function __construct(private Envelope $envelope)
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return get_class($this->envelope->getMessage());
    }

    public function getException(): string
    {
        /** @var ErrorDetailsStamp[] $stamps */
        $stamps = $this->envelope->all(ErrorDetailsStamp::class);
        return $stamps[0]->getExceptionMessage();
    }
    public function getFlattenMessage(): ?FlattenException
    {
        /** @var ErrorDetailsStamp[] $stamps */
        $stamps = $this->envelope->all(ErrorDetailsStamp::class);
        return $stamps[0]->getFlattenException();
    }
}

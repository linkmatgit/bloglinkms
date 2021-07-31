<?php

namespace App\Infrastructure\Queue\FailedJobs;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Receiver\ListableReceiverInterface;

class FailedJobRepository
{

    public function __construct(private ListableReceiverInterface $listableReceiver)
    {
    }

    public function allFailedJob(): array
    {
        return  array_map(
            fn (Envelope $envelope) => new FailedJob($envelope),
            iterator_to_array($this->listableReceiver->all())
        );
    }

    public function reject(string $id):void
    {

        $this->listableReceiver->reject($this->listableReceiver->find($id));
    }
}

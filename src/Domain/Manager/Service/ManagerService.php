<?php

declare(strict_types=1);

namespace App\Domain\Manager\Service;

use App\Domain\Manager\Dto\ManageableDto;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use App\Domain\Profile\Dto\ModDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ManagerService
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em,
    ) {
    }

    public function approuveModManager(Mod $data): void
    {

            $data->setApprouve(1);
        $data->setStatut(0);
        $data->setApprouveAt(new \DateTime());
            $this->dispatcher->dispatch(new ModAcceptedEvent($data));
            $this->em->flush();

    }

    public function rejectModManage(ManageableDto $data):void
    {
        $data->mod->setDetail($data->detail);
        $data->mod->setRejetTime($data->rejetTime);
        $data->mod->setApprouve(2);
        $data->mod->setApprouveBy($data->approuveBy);
        $data->mod->setApprouveAt(new \DateTime());
        $data->mod->setUrlOfMod($data->urlOfMod);
        $this->em->flush();
        $this->dispatcher->dispatch(new ModRejectedEvent($data->mod));
    }
}

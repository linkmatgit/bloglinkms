<?php

declare(strict_types=1);

namespace App\Domain\Manager\Service;

use App\Domain\Auth\User;
use App\Domain\Manager\Dto\ManageableDto;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ManagerService
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em,
    ) {
    }

    public function approuveModManager(ManageableDto $data)
    {
        $data->mod->setApprouve(1);
        $data->mod->setStatut(0);
        $data->mod->setApprouveAt(new \DateTime());
        $this->em->flush();
        $this->dispatcher->dispatch(new ModAcceptedEvent($data->mod));
    }

    public function rejectModManage(ManageableDto $data)
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

<?php

namespace App\Domain\Profile;

use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ModsCreateService
{

    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em
    ) {
    }

    public function createMod(Mod $data): void
    {
        $data->setTitle($data->getTitle());
        $data->setAuthor($data->getAuthor());
        $data->setUrl($data->getUrl());
        $data->setVersion($data->getVersion());
        $data->setBrand($data->getBrand());
        $data->setCategory($data->getCategory());
        $data->setConsole($data->isConsole());
        $data->setContent($data->getContent());
        $this->em->flush();
        $this->dispatcher->dispatch(new ModCreatedEvent($data));
    }
    public function updateMod(Mod $mod)
    {
        $mod->setUpdatedAt(new \DateTime());
        $this->em->flush();
        $this->dispatcher->dispatch(new ModUpdatedEvent($mod));
    }


}

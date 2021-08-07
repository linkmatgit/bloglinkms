<?php

namespace App\Domain\Profile;

use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use App\Domain\Profile\Dto\ModDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Security;

class ModsCreateService
{

    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em
    ) {
    }

    public function createMod(ModDto $data): void
    {
        $data->mod->setTitle($data->title);
        $data->mod->setAuthor($data->author);
        $data->mod->setUrl($data->url);
        $data->mod->setVersion($data->version);
        $data->mod->setBrand($data->brand);
        $data->mod->setCategory($data->category);
        $data->mod->setConsole($data->console);
        $data->mod->setContent($data->content);
        $this->em->flush();
        $this->dispatcher->dispatch(new ModCreatedEvent($data->mod));
    }
    public function updateMod(Mod $mod)
    {
        $mod->setUpdatedAt(new \DateTime());
        $this->em->flush();
        $this->dispatcher->dispatch(new ModUpdatedEvent($mod));
    }


}

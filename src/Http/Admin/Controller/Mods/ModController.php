<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModDeletedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\BrandsCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods', name: 'mod_')]
class ModController extends CrudController
{
    protected string $templatePath = 'mods/';
    protected string $menuItem = 'mod';
    protected string $entity = Mod::class;
    protected string $routePrefix = 'admin_mod';
    protected array $events = [
        'update' => ModUpdatedEvent::class,
        'delete' =>  ModDeletedEvent::class,
        'create' =>  ModCreatedEvent::class,
        'accepted' => ModAcceptedEvent::class,
        'rejected' => ModRejectedEvent::class
    ];


    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $this->paginator->allowSort('row.id', 'row.name');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
        ;

        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $entity = (new Brand());
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());
        $data = new BrandsCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Brand $row): Response
    {
        $data = (new BrandsCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }
    

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Brand $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

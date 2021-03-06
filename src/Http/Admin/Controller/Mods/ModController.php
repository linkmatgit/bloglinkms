<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\User;
use App\Domain\Mods\Event\ModDeletedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use App\Domain\Mods\Helper\ModCloner;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\ModCrudData;
use App\Http\Helper\Paginator\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods', name: 'mod_')]
class ModController extends CrudController
{
    protected string $templatePath = 'mods/';
    protected string $menuItem = 'mods';
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

        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
        ;
        $this->paginator->allowSort('row.id', 'row.title', 'row.approuve');
        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $entity = (new Mod());
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());

        $data = new ModCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Mod $row): Response
    {
        $data = (new ModCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }
    #[Route('/{id<\d+>}/clone', name: 'clone', methods: ['GET', 'POST'])]
    public function clone(Mod $rows): Response
    {
        $row = ModCloner::clone($rows);
        $data = new ModCrudData($row);
        return $this->crudNew($data);
    }

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Mod $rows): Response
    {
        return $this->crudDelete($rows);
    }

    #[Route('/search', name: 'autocomplete')]
    public function search(Request $request): JsonResponse
    {
        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(Mod::class);
        $q = strtolower($request->query->get('q') ?: '');

        $users = $repository
            ->createQueryBuilder('m')
            ->select('m.id', 't.title')
            ->where('LOWER(m.title) LIKE :title')
            ->setParameter('title', "%$q%")
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();

        return new JsonResponse($users);
    }
}

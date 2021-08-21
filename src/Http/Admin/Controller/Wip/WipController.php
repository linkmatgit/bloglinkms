<?php


namespace App\Http\Admin\Controller\Wip;

use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Mods\Helper\ModCloner;
use App\Domain\Mods\Entity\Mod;
use App\Domain\WIP\Entity\WipTag;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\ModCrudData;
use App\Http\Admin\Data\WipCrudData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wip', name: 'wip_')]
class WipController extends CrudController
{
    protected string $templatePath = 'wip';
    protected string $menuItem = 'wip';
    protected string $entity = WipTag::class;
    protected string $routePrefix = 'admin_wip';
    protected array $events = [
        'update' => null,
        'delete' =>  null,
        'create' =>  null,
        'accepted' => null,
        'rejected' => null,
    ];


    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {

        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
        ;
        $this->paginator->allowSort('row.id', 'row.name', 'row.approuve');
        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $entity = (new WipTag());
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());

        $data = new WipCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(WipTag $row): Response
    {
        $data = (new WipCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }


    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(WipTag $rows): Response
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

<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Event\PostCreatedEvent;
use App\Domain\Blog\Event\PostDeletedEvent;
use App\Domain\Blog\Event\PostUpdatedEvent;
use App\Domain\Blog\Helper\PostCloner;
use App\Domain\Group\Entity\Group;
use App\Http\Admin\Data\PostCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group_')]
class GroupController extends CrudController
{

    protected string $templatePath = 'group';
    protected string $menuItem = 'group';
    protected string $entity = Group::class;
    protected string $routePrefix = 'admin_group';
    protected array $events = [
    'update' => null,
    'delete' => null,
    'create' => null,
    ];



    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $this->paginator->allowSort();
        $query = $this->getRepository()
        ->createQueryBuilder('row')
       ->orderby('row.createdAt', 'DESC')
        ;

        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $entity = (new Group())->setCreatedAt(new \DateTime())->setAuthor($this->getUser());
        $data = new PostCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Post $row): Response
    {
        $data = (new PostCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }

    #[Route('/{id<\d+>}/clone', name: 'clone', methods: ['GET', 'POST'])]
    public function clone(Post $rows): Response
    {
        $row = PostCloner::clone($rows);
        $data = new PostCrudData($row);
        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Post $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

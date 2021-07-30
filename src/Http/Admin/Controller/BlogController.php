<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Event\PostCreatedEvent;
use App\Domain\Blog\Event\PostDeletedEvent;
use App\Domain\Blog\Event\PostUpdatedEvent;
use App\Domain\Blog\Helper\PostCloner;
use App\Http\Admin\Data\PostCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog_')]
class BlogController extends CrudController
{

    protected string $templatePath = 'blog';
    protected string $menuItem = 'blog';
    protected string $entity = Post::class;
    protected string $routePrefix = 'admin_blog';
    protected array $events = [
    'update' => PostUpdatedEvent::class,
    'delete' => PostDeletedEvent::class,
    'create' => PostCreatedEvent::class,
    ];



    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $this->paginator->allowSort('row.id');
        $query = $this->getRepository()
        ->createQueryBuilder('row')
        ->orderby('row.createdAt', 'DESC')
        ;

        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $entity = (new Post())->setCreatedAt(new \DateTime())->setAuthor($this->getUser());
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

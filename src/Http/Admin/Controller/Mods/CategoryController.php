<?php

namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Category;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\CategoryCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods/category', name: 'mod_category_')]
class CategoryController extends CrudController
{
    protected string $templatePath = 'mods/category';
    protected string $menuItem = 'mod_category';
    protected string $entity = Category::class;
    protected string $routePrefix = 'admin_mod_category';
    protected array $events = [
        'update' => null,
        'delete' =>  null,
        'create' =>  null,
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
        $entity = (new Category());
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());
        $data = new CategoryCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Category $row): Response
    {
        $data = (new CategoryCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }

  /*  #[Route('/{id<\d+>}/clone', name: 'clone', methods: ['GET', 'POST'])]
    public function clone(Post $rows): Response
    {
        $row = PostCloner::clone($rows);
        $data = new PostCrudData($row);
        return $this->crudNew($data);
    }
*/

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Category $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

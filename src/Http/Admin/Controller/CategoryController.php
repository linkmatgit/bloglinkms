<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Category;
use App\Http\Admin\Data\CategoryCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/category', name: 'category_')]
class CategoryController extends CrudController
{

    protected string $templatePath = 'blog/category';
    protected string $menuItem = 'category';
    protected string $entity = Category::class;
    protected string $routePrefix = 'admin_category';
    protected array $events = [
    'update' => null,
    'delete' => null,
    'create' => null,
    ];



    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $this->paginator->allowSort('row.id', 'row.name');
        $query = $this->getRepository()
        ->createQueryBuilder('row')
          ->groupBy('row.id')
          ->orderBy('row.id', 'DESC');

        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $category = new Category();
        $category->setAuthor($this->getUser());
        $category->setCreatedAt(new \DateTime());
        $data = new CategoryCrudData($category);
        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Category $row): Response
    {
        $data = (new CategoryCrudData($row));
        return $this->crudEdit($data);
    }

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Category $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

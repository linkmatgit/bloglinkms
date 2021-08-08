<?php

namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\ModCategory;
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
    protected string $entity = ModCategory::class;
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

    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        $entity = new ModCategory();
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());
        $entity->setPosition(1);
        $data = new CategoryCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(ModCategory $row): Response
    {
        $data = (new CategoryCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }



    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(ModCategory $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

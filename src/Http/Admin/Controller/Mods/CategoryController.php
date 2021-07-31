<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Category;
use App\Http\Admin\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods/category', name: 'mod_category_')]
class CategoryController extends CrudController
{
    protected string $templatePath = 'mods/category';
    protected string $menuItem = 'mod_category';
    protected string $entity = Category::class;
    protected string $routePrefix = 'mod_category';
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
}
<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Brand;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\BrandsCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods/brand', name: 'mod_brand_')]
class BrandController extends CrudController
{
    protected string $templatePath = 'mods/brand';
    protected string $menuItem = 'brand';
    protected string $entity = Brand::class;
    protected string $routePrefix = 'admin_mod_brand';
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

  /*  #[Route('/{id<\d+>}/clone', name: 'clone', methods: ['GET', 'POST'])]
    public function clone(Post $rows): Response
    {
        $row = PostCloner::clone($rows);
        $data = new PostCrudData($row);
        return $this->crudNew($data);
    }
*/

    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Brand $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

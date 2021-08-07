<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller\Manager;


use App\Domain\Manager\Reason;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\ModReasonCrudData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manager/reason', name: 'reason_')]
class ReasonController extends CrudController
{

    protected string $templatePath = 'reason';
    protected string $menuItem = 'reason';
    protected string $entity = Reason::class;
    protected string $routePrefix = 'admin_reason';
    protected array $events = [
        'update' => null,
        'delete' => null,
        'create' => null,
    ];



    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $this->paginator->allowSort('row.id');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
        ;

        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {

        $entity = (new Reason());
        $data = new ModReasonCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Reason $row): Response
    {
        $data = (new ModReasonCrudData($row));

        return $this->crudEdit($data);
    }


    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Reason $rows): Response
    {
        return $this->crudDelete($rows);
    }
}

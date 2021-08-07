<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Manager\Dto\ManageableDto;
use App\Domain\Manager\Service\ManagerService;
use App\Domain\Mods\Event\ModDeletedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use App\Domain\Mods\Helper\ModCloner;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use App\Domain\Mods\Repository\ModRepository;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Form\ModAcceptFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mods', name: 'mod_')]
class ReleaseController extends CrudController
{
    protected string $templatePath = 'mods/';
    protected string $menuItem = 'mods';
    protected string $entity = Mod::class;
    protected string $routePrefix = 'admin_mod';
    protected array $events = [
        'update' => ModUpdatedEvent::class,
        'delete' => ModDeletedEvent::class,
        'create' => ModCreatedEvent::class,
        'accepted' => ModAcceptedEvent::class,
        'rejected' => ModRejectedEvent::class
    ];

    #[Route('/release/{id<\d+>}', name:'release_mods', methods: ['POST', 'GET'])]
    public function viewRelease(Mod $rows, ModRepository $r, ManagerService $service, Request $request): Response
    {

        return $this->render('admin/mods/manager/release.html.twig', [
            'mods' =>     $r->queryModApprouveByUser($rows->getAuthor())->setMaxResults(10)->getResult(),
            'rows' => $rows,
            'menu' => 'mods'
        ]);
    }

    #[Route('/release/{id<\d+>}/accept', name: 'released_accept', methods:['POST'])]
    public function acceptMod(Mod $data, ManagerService $service):Response
    {
        //$this->denyAccessUnlessGranted(ModVoter::EDIT, $data);
        $user = $this->getUser();
        $service->approuveModManager($data);
        $data->setApprouveBy($user);
        $this->em->persist($data);
        $this->addFlash('success', 'Votre mod a ete mis a jours');
        return $this->redirectToRoute('admin_home');
    }

    #[Route('/release', name: 'release')]
    public function release(): Response
    {
        $this->paginator->allowSort('row.id', 'row.name');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')->where('row.approuve = 0')
        ;

        return $this->crudRelease($query);
    }

}

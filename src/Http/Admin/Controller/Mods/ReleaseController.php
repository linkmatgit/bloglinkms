<?php


namespace App\Http\Admin\Controller\Mods;

use App\Domain\Manager\Service\ManagerService;
use App\Domain\Mods\Event\ModDeletedEvent;
use App\Domain\Mods\Event\ModRejectedEvent;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Event\ModAcceptedEvent;
use App\Domain\Mods\Event\ModCreatedEvent;
use App\Domain\Mods\Event\ModUpdatedEvent;
use App\Domain\Mods\Repository\ModRepository;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Form\DeclineModFormType;
use App\Infrastructure\Security\TokenGeneratorService;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/release', name: 'release')]
    public function release(): Response
    {
        $this->paginator->allowSort('row.id', 'row.name');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
            ->where('row.approuve = 0')
            ->andWhere('row.statut = 0' )
        ;

        return $this->crudRelease($query);
    }
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
        return $this->redirectToRoute('admin_mod_release');
    }


    #[Route('/release/decline/{id<\d+>}', name: 'release_decline')]
    public function decline(Mod $rows, Request $request, TokenGeneratorService $generator): RedirectResponse|Response
    {
            $rows->setApprouveBy($this->getUser());
            $rows->setApprouveAt(new \DateTime());
            if($rows->getApprouve() === 0) {
                $rows->setApprouve(1);
            }
            $form =  $this->createForm(DeclineModFormType::class, $rows);
            $form->handleRequest($request);

            if($rows->getRejetTime() !== null) {
                $time =  (int)$rows->getRejetTime() + 1;
                $rows->setRejetTime($time);
            }else {
                $rows->setRejetTime(1);
            }
            if($rows->getRejetTime() === 4) {
                $rows->setStatut(1);
                $gen = $generator->generate(20);
                $old = $rows->getSlug();
                $slug = "$old" . '-' . "$gen";
                $rows->setSlug($slug);
            }
            if($rows->getRejetTime() > 4) {

                return $this->redirectToRoute('admin_mod_release_mods', ['id' => $rows->getId()]);
            }
            if ($form->isSubmitted() && $form->isValid()){

                $this->em->persist($rows);
                $this->em->flush();
                $this->addFlash('error', 'Le Mods a ete refusée');
            }
        return $this->render('admin/mods/manager/decline.html.twig', [
            'rows' => $rows,
            'form'     => $form->createView()
        ]);
    }

    #[Route('/release/decline/', name: 'release_decline_index')]
    public function getDelcine(): Response
    {
        $this->paginator->allowSort('row.id', 'row.name');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
            ->where('row.approuve = 2')
            ->andWhere('row.statut = 0' )
        ;
        return $this->crudDecline($query);
    }
    #[Route('/release/reset/{id<\d+>}', name: 'release_decline_reset' )]
    public function resetRelease(Mod $rows){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->getUser();
        if($this->getUser()->getName() !== 'Linkmat') {
            return;
        }
        $rows->setStatut(0);
        $rows->setApprouve(0);
        $rows->setDetail(null);
        $rows->setApprouveBy(null);
        $rows->setRejetTime(null);
        $this->em->persist($rows);
        $this->em->flush();
        $this->addFlash('success', 'Le Mod a ete Reinitialisée');
        return $this->redirectToRoute('admin_mod_release_mods', ['id' => $rows->getId()]);
    }

}

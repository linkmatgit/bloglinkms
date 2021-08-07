<?php declare(strict_types=1);

namespace App\Http\Controller\Accounts\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Repository\ModRepository;
use App\Domain\Profile\Dto\ModDto;
use App\Domain\Profile\ModsCreateService;
use App\Http\Controller\AbstractController;
use App\Http\Form\ModPublicFormType;
use App\Http\Security\ModVoter;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class OwnModController extends AbstractController
{

    public function __construct(
        private ModRepository $modRepository,
        private ModsCreateService $createService,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/profil/mods/submit/{id<\d+>}', name: 'mod_submit_show', methods: ['GET'])]
    public function submitedMod(Mod $mod): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($mod->getRejetTime() < 4) {
            return $this->render('users/accounts/show_private_mod.html.twig', [
            'mods' => $mod,
            'user' => $this->getUserOrThrow(),
            'menu' => 'mods'
            ]);
        }
                return $this->render('users/accounts/close_mod_reject.html.twig', [
                'mods' => $mod,
                'user' => $this->getUserOrThrow(),
                'menu' => 'mods'
                ]);
    }

    #[Route('/profil/mods/submit', name: 'mod_submit', methods: ['GET'])]
    public function viewSubmit():Response
    {
        /**
         * @var  User $user
         */
        $user = $this->getUser();
        return $this->render('users/accounts/mysubmitMods.html.twig', [
            'privates' => $this->modRepository->queryModNotApprouveByUser($user)->getResult(),
            'user' => $user,
            'menu' => 'mods',
             'titlePage' => 'en Attente'
        ]);
    }
    #[Route('/profil/mods', name: 'mod_own', methods: ['GET'])]
    public function myMods():Response
    {
        /**
         * @var  User $user
         */
        $user = $this->getUser();
        return $this->render('users/accounts/myMod.html.twig', [
            'privates' => $this->modRepository->queryModApprouveByUser($user)->getResult(),
            'submits' => $this->modRepository->queryModNotApprouveByUser($user)->getResult(),
            'user' => $user,
            'menu' => 'mods',
            'titlePage' => ' '
        ]);
    }

    #[Route('/profil/mods/new', name: 'mod_new')]
    public function createMod(Request $request):Response
    {
        $this->denyAccessUnlessGranted(ModVoter::CREATE);
            $user = $this->getUserOrThrow();
            $mod = (new Mod())->setAuthor($user)->setCreatedAt(new \DateTime());
            $form = $this->createForm(ModPublicFormType::class, new ModDto($mod));
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->createService->createMod($data);
            $this->em->persist($data);
            $this->addFlash('success', 'Votre profil a bien été mis à jour');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('users/accounts/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'menu' => 'mods',
        ]);
    }

    #[Route('/profil/mods/{id<\d+>}', name: 'mod_edit')]
    public function editMod(Mod $data, Request $request): Response
    {
        if ($data->getApprouve()  === 1) {
            $this->denyAccessUnlessGranted(ModVoter::APPROUVED, $data);
        }
        $this->denyAccessUnlessGranted(ModVoter::EDIT, $data);
        $user = $this->getUserOrThrow();
        $form = $this->createForm(ModPublicFormType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->createService->updateMod($data);
            $this->em->persist($data);
            $this->addFlash('success', 'Votre mod a ete mis a jours');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('users/accounts/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'menu' => 'mods',
        ]);
    }
    #[Route('/profil/mods/event/new', name: 'mod_event_new')]
    public function eventMod(Request $request): RedirectResponse|Response
    {
        $this->denyAccessUnlessGranted(ModVoter::CREATE);
        $user = $this->getUserOrThrow();
        $mod = (new Mod())->setAuthor($user)->setCreatedAt(new \DateTime());
        $form = $this->createForm(ModPublicFormType::class, new ModDto($mod));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->createService->createMod($data);
            $this->em->persist($data);
            $this->addFlash('success', 'Votre profil a bien été mis à jour');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('users/accounts/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'menu' => 'mods',
        ]);
    }

}

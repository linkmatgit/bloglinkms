<?php declare(strict_types=1);

namespace App\Http\Controller\Accounts\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Exception\ClosedModException;
use App\Domain\Mods\Repository\ModRepository;
use App\Http\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
/**
 * @var User $user
 */
class OwnModController  extends AbstractController {

    public function __construct(private ModRepository $modRepository)
    {
    }

    #[Route('/profil/mods/submit/{id<\d+>}' , name: 'mod_submit_show', methods: ['GET'])]
    public function submited(Mod $mod)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
    if($mod->getRejetTime() < 4) {
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

    #[Route('/profil/mods/submit' , name: 'mod_submit', methods: ['GET'])]
    public function viewSubmit() {
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
    #[Route('/profil/mods' , name: 'mod_own', methods: ['GET'])]
    public function myMods(){
        /**
         * @var  User $user
         */
        $user = $this->getUser();
        return $this->render('users/accounts/myMod.html.twig', [
            'privates' => $this->modRepository->queryModApprouveByUser($user)->getResult(),
            'user' => $user,
            'menu' => 'mods',
            'titlePage' => ' '
        ]);
    }
}
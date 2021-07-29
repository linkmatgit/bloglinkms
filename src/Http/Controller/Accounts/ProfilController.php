<?php

namespace App\Http\Controller\Accounts;

use App\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{


    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('users/accounts/profile.html.twig', []);
    }

}
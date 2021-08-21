<?php

declare(strict_types=1);

namespace App\Http\Controller;

   use Symfony\Component\HttpFoundation\Response;
   use Symfony\Component\Routing\Annotation\Route;

final class UserController extends AbstractController
{

    #[Route('/user', name: 'user_show')]
    public function home(): Response
    {
        return $this->render('index.html.twig', [
            'menu' => 'home']);
    }

}

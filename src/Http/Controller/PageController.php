<?php

declare(strict_types=1);

namespace App\Http\Controller;

   use App\Domain\Mods\Repository\ModRepository;
   use Symfony\Component\HttpFoundation\Response;
   use Symfony\Component\Routing\Annotation\Route;

final class PageController extends AbstractController
{
    public function __construct(private ModRepository $rm)
    {
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('index.html.twig', [
            'menu' => 'home',
            'mods' => $this->rm->findRecentModWithLimit()->getResult()
        ]);
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response {
           return $this->render('pages/about.html.twig');
    }
}

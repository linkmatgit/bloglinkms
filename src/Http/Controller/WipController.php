<?php
declare(strict_types=1);

namespace App\Http\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('wip', name: 'wip_')]
class WipController extends AbstractController
{

    private string $menu = 'wip';


    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $title = 'Le Wip Recents';
        return $this->render('wip/index.html.twig', [
            'title' => $title,
            'menu' => $this->menu
        ]);

    }




}

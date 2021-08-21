<?php
declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Repository\CategoryRepository;
use App\Domain\Mods\Repository\ModRepository;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

<?php


namespace App\Http\Admin\Controller;


use App\Domain\Blog\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends BaseController
{
  protected string $menuItem = 'home';

  #[Route("/", name: 'home')]
  public function home(): Response {

    return $this->render('admin/pages/home.html.twig', [
      'menu' => $this->menuItem
    ]);
  }
}

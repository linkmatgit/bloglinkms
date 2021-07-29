<?php


namespace App\Http\Admin\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends BaseController
{

  #[Route("/", name: 'home')]
  public function home(): Response {

    return $this->render('admin/pages/home.html.twig');
  }
}

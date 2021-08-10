<?php

namespace App\Http\Controller\Forums;

use App\Domain\Forum\Repository\TagRepository;
use App\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{

    public function __construct(private TagRepository $tr)
    {
    }
    #[Route('forum', name: 'app_forum')]
    public function index(): Response
    {
        return $this->render('forums/index.html.twig', [
            'menu' => 'forum',
            'tags' => $this->tr->findAllOrdered()
        ]);
    }
}

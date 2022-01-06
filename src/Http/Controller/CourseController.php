<?php

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('tutoriels', name: 'course_')]
class CourseController extends AbstractController
{

    private string $menuItem = 'course';

    #[Route('/', name: 'index')]
    public function index(): Response
    {

        return $this->render(
            'course/index.html.twig',
            [
            'menu' => $this->menuItem
            ]
        );
    }
}

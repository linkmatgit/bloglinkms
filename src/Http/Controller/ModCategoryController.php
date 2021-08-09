<?php

namespace App\Http\Controller;

use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('category', name: 'category_')]
class ModCategoryController extends AbstractController
{

    public function __construct(private CategoryRepository $repository)
    {
    }

    #[Route('/', name: 'index')]
    public function listingCategory(): Response{

        return $this->render('mods/category.html.twig', [
            'categories' => $this->repository->findAllOrdered(),
            'menu' => 'category'
        ]);
    }


}
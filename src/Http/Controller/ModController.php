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

#[Route('mods', name: 'mods_')]
class ModController extends AbstractController
{

    private string $menu = 'mods';
    public function __construct(
        private ModRepository $repository,
        private PaginatorInterface $paginator,
        private CategoryRepository $categoryRepository
    ) {
    }
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $title = 'Les Mod Recents';
            $query = $this->repository->findForCategory();

        return $this->renderListing($title, $query, $request);
    }

    #[Route('/{slug<[a-z0-9A-Z\-]+>}-{id<\d+>}', name: 'show')]
    public function show(Mod $mod)
    {

        if ($mod->getApprouve() != 1 || $mod->getStatut() === 1 )
        {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('mods/show.html.twig', [
            'mod' => $mod
        ]);
    }

    #[Route('/category/{slug<[a-z0-9A-Z\-]+>}', name: 'category')]
    public function category(Category $category, Request $request): Response
    {
        $title = $category->getName();
        $query = $this->repository->findForCategory($category);

        return $this->renderListing($title, $query, $request, ['category' => $category]);
    }
    private function renderListing(string $title, Query $query, Request $request, array $params = []): Response
    {
        $page = $request->query->getInt('page', 1);

        $mods = $this->paginator->paginate($query, $page, 12);

        if ($page > 1) {
            $title .= ", page $page";
        }

        if (0 === $mods->count()) {
            throw new NotFoundHttpException('Aucun articles ne correspond à cette page');
        }

        $categories = $this->categoryRepository->findWithCount();

        return $this->render('mods/index.html.twig', array_merge([
            'mods' => $mods,
            'categories' => $categories,
            'page' => $page,
            'title' => $title,
            'menu' => 'mods',
        ], $params));
    }


}

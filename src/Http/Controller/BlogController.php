<?php
declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Repository\CategoryRepository;
use App\Domain\Blog\Repository\PostRepository;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('blog', name: 'blog_')]
class BlogController extends AbstractController
{

    private string $menu = 'mods';
    public function __construct(
        private PostRepository $repository,
        private PaginatorInterface $paginator,
        private CategoryRepository $categoryRepository
    ) {
    }
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $title = 'Blog';
        $query = $this->repository->queryAll();

        return $this->renderListing($title, $query, $request);
    }


    #[Route('/{slug<[a-z0-9A-Z\-]+>}', name: 'show')]
    public function show(Post $post): Response
    {
        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'menu' => 'blog',
        ]);
    }

    #[Route('/category/{slug<[a-z0-9A-Z\-]+>}', name: 'category')]
    public function category(Category $category, Request $request): Response
    {
        $title = $category->getName();
        $query = $this->repository->queryAll($category);

        return $this->renderListing($title, $query, $request, ['category' => $category]);

    }

    private function renderListing(string $title, Query $query, Request $request, array $params = []): Response
    {
        $page = $request->query->getInt('page', 1);
        $posts = $this->paginator->paginate(
            $query,
            $page,
            10
        );
        if ($page > 1) {
            $title .= ", page $page";
        }
        if (0 === $posts->count()) {
            throw new NotFoundHttpException('Aucun articles ne correspond à cette page');
        }
        $categories = $this->categoryRepository->findWithCount();

        return $this->render('blog/index.html.twig', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'page' => $page,
            'title' => $title,
            'menu' => 'blog',
        ], $params));
    }


}

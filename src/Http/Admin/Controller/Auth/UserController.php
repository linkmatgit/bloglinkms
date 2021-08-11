<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller\Auth;

use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\User;
use App\Http\Admin\Controller\BaseController;
use App\Http\Admin\Controller\CrudController;
use App\Http\Helper\Paginator\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users', name: 'user_')]
class UserController extends BaseController
{

    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/', name: 'index')]
    public function index(QueryBuilder $query = null): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $query = $query ?: $this->em->getRepository(User::class)
            ->createQueryBuilder('row')
            ->orderBy('row.createdAt', 'DESC');
        if ($request->get('q')) {
            $query = $this->applySearch(trim($request->get('q')), $query);
        }
        $this->paginator->allowSort('row.id', 'row.title');
        $rows = $this->paginator->paginate($query->getQuery());
        return $this->render('admin/users/index.html.twig', [
            'rows' => $rows,
            'searchable' => true,
        ]);
    }

    #[Route('/search', name: 'autocomplete')]
    public function search(Request $request): JsonResponse
    {
      /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);
        $q = strtolower($request->query->get('q') ?: '');
        if ('moi' === $q) {
            return new JsonResponse([[
            'id' => $this->getUser()->getId(),
            'username' => $this->getUser()->getUsername(),
            ]]);
        }
        $users = $repository
        ->createQueryBuilder('u')
        ->select('u.id', 'u.name')
        ->where('LOWER(u.name) LIKE :name')
        ->setParameter('name', "%$q%")
        ->setMaxResults(25)
        ->getQuery()
        ->getResult();

        return new JsonResponse($users);
    }
}

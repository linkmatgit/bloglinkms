<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller\Auth;

use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Event\PostCreatedEvent;
use App\Domain\Blog\Event\PostDeletedEvent;
use App\Domain\Blog\Event\PostUpdatedEvent;
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
class UserController extends CrudController
{
    protected string $templatePath = 'users';
    protected string $menuItem = 'user';
    protected string $entity = User::class;
    protected string $routePrefix = 'admin_user';
    protected array $events = [
        'update' => null,
        'delete' => null,
        'create' => null,
    ];



    #[Route('/', name: 'index')]
    public function index(QueryBuilder $query = null): Response
    {

        $this->paginator->allowSort('row.id');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC')
        ;

        return $this->crudIndex($query);
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

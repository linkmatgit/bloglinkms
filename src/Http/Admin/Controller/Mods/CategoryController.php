<?php

namespace App\Http\Admin\Controller\Mods;

use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Repository\CategoryRepository;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\Mods\CategoryCrudData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/mods/category', name: 'mod_category_')]
class CategoryController extends CrudController
{
    protected string $templatePath = 'mods/category';
    protected string $menuItem = 'mod_category';
    protected string $entity = Category::class;
    protected string $routePrefix = 'admin_mod_category';
    protected string $searchField = 'name';
    protected array $events = [
        'update' => null,
        'delete' =>  null,
        'create' =>  null,
    ];


    #[Route('/', name: 'index')]
    public function index(SerializerInterface $serializer, CategoryRepository $repository, Request $request): Response
    {
        return $this->render("admin/{$this->templatePath}/index.html.twig", [
            'rows' => $serializer->serialize($repository->findTree(), 'json'),
            'menu' => $this->menuItem,
            'prefix' => $this->routePrefix,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        $entity = new Category();
        $entity->setCreatedAt(new \DateTime());
        $entity->setAuthor($this->getUser());
        $entity->setPosition(1);
        $data = new CategoryCrudData($entity);

        return $this->crudNew($data);
    }


    #[Route('/{id<\d+>}', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Category $row): Response
    {
        $data = (new CategoryCrudData($row))->setEntityManager($this->em);

        return $this->crudEdit($data);
    }



    #[Route('/{id<\d+>}', methods: ['DELETE'])]
    public function delete(Request $request, Category $post): Response
    {
        $response = $this->crudDelete($post);
        if (in_array('application/json', $request->getAcceptableContentTypes())) {
            return new JsonResponse([]);
        }

        return $response;
    }


    #[Route('/positions', name: 'positions')]
    public function sort(Request $request, CategoryRepository $tagRepository, EntityManagerInterface $em): Response
    {
        ['positions' => $positions] = json_decode((string) $request->getContent(), true);
        $positionById = array_reduce($positions, function ($acc, $position) {
            $acc[$position['id']] = $position;

            return $acc;
        }, []);
        $tags = $tagRepository->findBy(['id' => array_keys($positionById)]);
        foreach ($tags as $tag) {
            $position = $positionById[$tag->getId()];
            $parent = null;
            if ($position['parent'] > 0) {
                /** @var CategoryRepository $parent */
                $parent = $this->em->getReference(Category::class, (int) $position['parent']);
            }
            $tag
                ->setParent($parent)
                ->setPosition($position['position'] + 1);
        }
        $em->flush();

        return new JsonResponse([], 200);
    }
}

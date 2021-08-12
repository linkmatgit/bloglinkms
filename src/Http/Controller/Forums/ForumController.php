<?php

namespace App\Http\Controller\Forums;

use App\Domain\Auth\User;
use App\Domain\Forum\Entity\Tag;
use App\Domain\Forum\Entity\Topic;
use App\Domain\Forum\Repository\TagRepository;
use App\Domain\Forum\Repository\TopicRepository;
use App\Domain\Forum\TopicService;
use App\Http\Controller\AbstractController;
use App\Http\Form\ForumTopicForm;
use App\Http\Helper\Paginator\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{

    public function __construct(
        private TagRepository $tr,
        private TopicService $topicService,
        private TopicRepository $topicRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/forum', name: 'forum')]
    public function index(Request $request): Response
    {

        return $this->tag($request, null);
    }

    #[Route('/forum/{slug<[a-z0-9\-]+>}-{id<\d+>}', name: 'forum_tag')]
    public function tag(Request $request, ?Tag $tag): Response
    {
        $topics = $this->paginator->paginate($this->topicRepository->queryAllForTag($tag));
        return $this->render('forums/index.html.twig', [
            'menu' => 'forum',
            'topics' => $topics,
            'tags' => $this->tr->findTree(),
            'page' => $request->query->getInt('page', 1),
            'current_tag' => $tag,
        ]);
    }
    /**
     * @Route("/forum/{id<\d+>}", name="forum_show")
     */
    #[Route('/forum/{id<\d+>}', name: 'forum_show')]
    public function show(Topic $topic): Response
    {
        $user = $this->getUser();

        return $this->render('forums/show.html.twig', [
            'topic' => $topic,
            'menu' => 'forum',
        ]);
    }

    #[Route('forum/new', name: 'forum_new')]
    public function create(Request $request): Response
    {
        //$this->denyAccessUnlessGranted(ForumVoter::CREATE);
        /** @var User $user */
        $user = $this->getUser();
        $topic = (new Topic())->setContent($this->renderView('forums/template/placeholder.text.twig'));
        $topic->setAuthor($user);
        $form = $this->createForm(ForumTopicForm::class, $topic);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->topicService->createTopic($topic);
            $this->addFlash('success', 'Le sujet a bien été créé');

            return $this->redirectToRoute('forum_show', ['id' => $topic->getId()]);
        }

        return $this->render('forums/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

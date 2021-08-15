<?php declare(strict_types=1);

namespace App\Domain\Comment;


use App\Domain\Application\Entity\Content;
use App\Domain\Auth\AuthService;
use Doctrine\ORM\EntityManagerInterface;

class CommentService {

    public function __construct(
        private EntityManagerInterface $em,
        private AuthService $auth
    )
    {
    }


    /**
     * @param CommentData $data
     * @return Comment
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(CommentData $data): Comment {

        $target = $this->em->getRepository(Content::class)->find($data->target);
        $parent = $data->parent  ? $this->em->getReference(Comment::class, $data->parent): null;
        $comment = (new Comment())
            ->setAuthor($this->auth->getUserOrNull())
            ->setUsername($data->username)
            ->setCreatedAt(new \DateTime())
            ->setContent($data->content)
            ->setParent($parent)
            ->setTarget($target);
        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    /**
     * @param Comment $comment
     * @param string $content
     * @return Comment
     */
    public function update(Comment $comment, string $content): Comment {
        $comment->setContent($content);
        $this->em->flush();
        return $comment;
    }

    /**
     * @param int $commentId
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(int $commentId): void {
        $comment = $this->em->getReference(Comment::class, $commentId);
        $this->em->persist($comment);
        $this->em->flush();
    }
}
<?php

namespace App\Http\Api\DataPersister;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Domain\Auth\User;
use App\Domain\Comment\CommentService;
use App\Http\Api\Resource\CommentResource;
use Symfony\Component\Security\Core\Security;

class CommentPersister
{
    public function __construct(
        private ValidatorInterface $validator,
        private Security $security,
        private CommentService $service
    )
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof CommentResource;

    }

    /**
     * @param $data
     * @param array $context
     * @return CommentResource
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist($data, array $context = []): CommentResource
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $groups = [];
        if (!$user instanceof User) {
            $groups = ['anonymous'];
        }
        $this->validator->validate($data, ['groups' => $groups]);

        if (null !== $data->entity) {
            $comment = $this->service->update($data->entity, $data->content);
        } else {
            $comment = $this->service->create($data);
        }

        return CommentResource::fromComment($comment);
    }

    /**
     * @param $data
     * @param array $context
     * @return CommentResource
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove($data, array $context = []): CommentResource
    {
        if (null === $data->id) {
            return $data;
        }
        $this->service->delete($data->id);

        return $data;
    }
}
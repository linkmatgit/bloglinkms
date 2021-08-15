<?php

namespace App\Http\Api\Resource;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Domain\Auth\User;
use App\Domain\Comment\Comment;
use App\Domain\Comment\CommentData;
use Parsedown;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[ApiResource(
    itemOperations: [
        'get' => [
            'controller', NotFoundAction::class,
            'read' => false,
            'output' => false
        ],
        'delete' => [''],
        'put' => ['']

    ],
    shortName: 'Comment',
    denormalizationContext: ['groups' => ['write:comment']],
    normalizationContext: ['groups'=> ['read:comment']]
)]

class CommentResource extends CommentData
{

    #[Groups(['read:comment'])]
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Groups(['read:comment', 'write:comment'])]
    #[Assert\NotBlank(normalizer: 'trim', groups: ['anonymous'])]
    public ?string $username = null;

    #[Assert\NotBlank(normalizer: 'trim')]
    #[Groups(['read:comment', 'write:comment'])]
    #[Assert\Length(min: 4, normalizer: 'trim')]
    public string $content = '';

    #[Groups(['read:comment'])]
    public string $html = '';

    #[Groups(['read:comment'])]
    public ?string $avatar = null;

    #[Groups(['write:comment'])]
    public ?int $target = null;

    #[Groups(['read:comment'])]
    public int $createdAt = 0;

    #[Groups(['read:comment', 'write:comment'])]
    public ?int $parent = 0;

    public ?Comment $entity = null;

    #[Groups(['read:comment'])]
    public ?int $userId = null;

    public static function fromComment(Comment $comment, ?UploaderHelper $uploaderHelper = null): CommentResource
    {
        $resource = new self();
        $author = $comment->getAuthor();
        $resource->id = $comment->getId();
        $resource->username = $comment->getUsername();
        $resource->content = $comment->getContent();
        $resource->html = strip_tags(
            (new Parsedown())
                ->setBreaksEnabled(true)
                ->setSafeMode(true)
                ->text($comment->getContent()),
            '<p><pre><code><ul><ol><li>'
        );
        $resource->createdAt = $comment->getCreatedAt()->getTimestamp();
        $resource->parent = null !== $comment->getParent() ? $comment->getParent()->getId() : 0;
       /* if ($author && $uploaderHelper && $author->getAvatarName()) {
            $resource->avatar = $uploaderHelper->asset($author, 'avatarFile');
        } else {
            $resource->avatar = '/images/default.png';
        }*/
        $resource->entity = $comment;
        $resource->userId = $author?->getId();

        return $resource;
    }
}
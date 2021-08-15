<?php declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\Application\Entity\Content;
use App\Domain\Auth\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Comment {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $content = ' ';

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?User $author;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'replies')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Comment::class)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $replies;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(name: 'content_id', nullable: false, onDelete: 'CASCADE')]
    private Content $target;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->replies = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Comment
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Comment
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        if(null !== $this->author) {
            return $this->author->getName();
        }
        return $this->username ?: '';
    }

    /**
     * @param string|null $username
     * @return Comment
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTime|\DateTimeInterface
     */
    public function getCreatedAt(): \DateTime|\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|\DateTimeInterface $createdAt
     * @return Comment
     */
    public function setCreatedAt(\DateTime|\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return Comment
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getParent(): ?Comment
    {
        return $this->parent;
    }

    /**
     * @param Comment|null $parent
     * @return Comment
     */
    public function setParent(?Comment $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getReplies(): ArrayCollection|Collection
    {
        return $this->replies;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
   public function addReply(Comment $comment):self {
        if(!$this->replies->contains($comment)){
            $this->replies->add($comment);
            $comment->setParent($this);
        }
        return $this;
   }

    /**
     * @return Content
     */
    public function getTarget(): Content
    {
        return $this->target;
    }

    /**
     * @param Content $target
     * @return Comment
     */
    public function setTarget(Content $target): self
    {
        $this->target = $target;
        return $this;
    }


}
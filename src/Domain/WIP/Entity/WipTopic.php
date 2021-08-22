<?php

namespace App\Domain\WIP\Entity;

use App\Domain\Auth\User;
use App\Domain\Manager\Manageable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table('wip_topic')]
class WipTopic
{
    use Manageable;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 4)]
    private ?string $content;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: WipTag::class, inversedBy: 'topics')]
    #[ORM\JoinColumn(nullable: true)]
    private ?WipTag $tags;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $author;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return WipTopic
     */
    public function setId(?int $id): WipTopic
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return WipTopic
     */
    public function setContent(?string $content): WipTopic
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return WipTopic
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): WipTopic
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return WipTopic
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): WipTopic
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return WipTopic
     */
    public function setName(string $name): WipTopic
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return WipTag|null
     */
    public function getTags(): ?WipTag
    {
        return $this->tags;
    }

    /**
     * @param WipTag|null $tags
     * @return WipTopic
     */
    public function setTags(?WipTag $tags): WipTopic
    {
        $this->tags = $tags;
        return $this;
    }
    

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return WipTopic
     */
    public function setAuthor(User $author): WipTopic
    {
        $this->author = $author;
        return $this;
    }
}

<?php

namespace App\Domain\Forum\Entity;

use App\Domain\Auth\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table("forum_topic")]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $solved = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $sticky = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private User $author;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'topics')]
    #[ORM\JoinColumn(name: 'forum_topic_tag')]
    #[Assert\NotBlank()]
    #[Assert\Count(min: 1, max: 3)]
    #[Groups(['read:topic'])]
    private Collection $tags;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $messageCount = 0;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return Topic
     */
    public function setId(?int $id): Topic
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Topic
     */
    public function setName(?string $name): Topic
    {
        $this->name = $name;
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
     * @return Topic
     */
    public function setContent(?string $content): Topic
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
    {
        return $this->solved;
    }

    /**
     * @param bool $solved
     * @return Topic
     */
    public function setSolved(bool $solved): Topic
    {
        $this->solved = $solved;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSticky(): bool
    {
        return $this->sticky;
    }

    /**
     * @param bool $sticky
     * @return Topic
     */
    public function setSticky(bool $sticky): Topic
    {
        $this->sticky = $sticky;
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
     * @return Topic
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): Topic
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
     * @return Topic
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Topic
    {
        $this->updatedAt = $updatedAt;
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
     * @return Topic
     */
    public function setAuthor(User $author): Topic
    {
        $this->author = $author;
        return $this;
    }
    /**
     * @return int
     */
    public function getMessageCount(): int
    {
        return $this->messageCount;
    }

    /**
     * @param int $messageCount
     * @return Topic
     */
    public function setMessageCount(int $messageCount): Topic
    {
        $this->messageCount = $messageCount;
        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}

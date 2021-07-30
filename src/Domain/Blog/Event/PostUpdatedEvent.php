<?php

declare(strict_types=1);

namespace App\Domain\Blog\Event;

use App\Domain\Blog\Entity\Post;

class PostUpdatedEvent
{
    public function __construct(private Post $post)
    {
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }
}

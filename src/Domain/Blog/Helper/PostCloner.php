<?php

namespace App\Domain\Blog\Helper;

use App\Domain\Blog\Entity\Post;

/**
 * Permet de dupliquer un cours en prenant en compte les associations.
 */
class PostCloner
{
    public static function clone(Post $rows): Post
    {
        $clone = new Post();
        $clone->setTitle($rows->getTitle());
        $clone->setSlug($rows->getSlug());
        $clone->setAuthor($rows->getAuthor());
        $clone->setOnline($rows->isOnline());
        $clone->setContent($rows->getContent());
        $clone->setCategory($rows->getCategory());
        $clone->setCreatedAt(new \DateTime());
        return $clone;
    }
}

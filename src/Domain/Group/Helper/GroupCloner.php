<?php

namespace App\Domain\Group\Helper;

use App\Domain\Group\Entity\Group;

/**
 * Permet de dupliquer un cours en prenant en compte les associations.
 */
class GroupCloner
{
    public static function clone(Group $rows): Group
    {
        $clone = new Group();
        $clone->setName($rows->getName());
        $clone->setAuthor($rows->getAuthor());
        $clone->setCreatedAt(new \DateTime());
        return $clone;
    }
}

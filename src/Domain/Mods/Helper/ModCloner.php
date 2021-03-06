<?php

namespace App\Domain\Mods\Helper;

use App\Domain\Mods\Entity\Mod;

/**
 * Permet de dupliquer un cours en prenant en compte les associations.
 */
class ModCloner
{
    public static function clone(Mod $rows): Mod
    {
        $clone = new Mod();
        $clone->setTitle($rows->getTitle());
        $clone->setAuthor($rows->getAuthor());
        $clone->setContent($rows->getContent());
        $clone->setCategory($rows->getCategory());
        $clone->setBrand($rows->getBrand());
        $clone->setCreatedAt(new \DateTime());
        $clone->setVersion($rows->getVersion());
        $clone->setUrl($rows->getUrl());
        $clone->setConsole($rows->isConsole());
        return $clone;
    }
}

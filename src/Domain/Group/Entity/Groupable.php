<?php declare(strict_types=1);

namespace App\Domain\Group\Entity;

use App\Domain\Group\Entity\Group;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait Groupable
{

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'members')]
    private ?Collection $groupe = null;

}

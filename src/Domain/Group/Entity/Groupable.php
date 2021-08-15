<?php declare(strict_types=1);

namespace App\Domain\Group\Entity;

use App\Domain\Group\Entity\Group;
use Doctrine\ORM\Mapping as ORM;

trait Groupable
{

    #[ORM\ManyToMany(targetEntity: Group::class)]
    #[ORM\JoinTable('group_user')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'group_id', referencedColumnName: 'id')]
    private ?Group $group = null;
}

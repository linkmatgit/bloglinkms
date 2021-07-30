<?php

declare(strict_types=1);

namespace App\Domain\Notification\Repository;

use App\Domain\Notification\Entity\Notification;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Notification>
 */
class NotificationRepository extends AbstractRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }
}

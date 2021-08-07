<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Category;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Unique;

class ModReasonCrudData extends AutomaticCrudData
{
    public ?string $name;

    public ?string $description;

    public string $key;

}

<?php

namespace App\Http\Admin\Data;

use Doctrine\ORM\EntityManagerInterface;


interface CrudDataInterface
{
    public function getEntity(): object;

    public function getFormClass(): string;

    public function hydrate(): void;


}
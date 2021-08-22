<?php

namespace App\Domain\Course;

use App\Domain\Application\Entity\Content;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

class Course extends Content
{

    #[ORM\Column( type: Types::STRING, nullable: true)]
    private ?string $comics;

    /**
     * @return string|null
     */
    public function getComics(): ?string
    {
        return $this->comics;
    }

    /**
     * @param string|null $comics
     * @return Course
     */
    public function setComics(?string $comics): Course
    {
        $this->comics = $comics;
        return $this;
    }



}
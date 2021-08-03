<?php declare(strict_types=1);

namespace App\Domain\Profile\Dto;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;

class ModDto
{

    public ?string $name;

    public User $author;

    public ?Mod $mod;

    public ?string $url;
    public ?string $description;
    public ?string  $version;
    public bool $console;
    public ?Category $category;
    public ?Brand $brand;

    public function __construct(Mod $mod)
    {
        $this->name = $mod->getName();
        $this->author = $mod->getAuthor();
        $this->mod = $mod;
        $this->url = $mod->getUrl();
        $this->description = $mod->getDescription();
        $this->version = $mod->getVersion();
        $this->console = $mod->isConsole();
        $this->brand = $mod->getBrand();
        $this->category = $mod->getCategory();
    }
    public function getId(): int
    {
        return $this->mod->getId() ?: 0;
    }


}

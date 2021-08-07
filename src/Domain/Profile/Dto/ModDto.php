<?php declare(strict_types=1);

namespace App\Domain\Profile\Dto;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;

class ModDto
{

    public ?string $title;

    public User $author;

    public ?Mod $mod;

    public ?string $url;
    public ?string $content;
    public ?string  $version;
    public bool $console;
    public ?Category $category;
    public ?Brand $brand;

    public function __construct(Mod $mod)
    {
        $this->title = $mod->getTitle();
        $this->author = $mod->getAuthor();
        $this->mod = $mod;
        $this->url = $mod->getUrl();
        $this->content = $mod->getContent();
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

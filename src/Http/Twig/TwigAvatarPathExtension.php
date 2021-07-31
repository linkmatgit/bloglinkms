<?php declare(strict_types=1);


namespace App\Http\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigAvatarPathExtension extends AbstractExtension {


  public function getFilters():array
  {
    return [
      new TwigFilter('avatar',  [$this, 'avatarPath'])
    ];
  }

  public function avatarPath(): ?string {
    return "/images/default.png";
  }
}

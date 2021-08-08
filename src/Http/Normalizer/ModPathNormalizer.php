<?php

namespace App\Http\Normalizer;

use App\Domain\Blog\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Http\Encoder\PathEncoder;
use App\Infrastructure\Normalizer\Normalizer;

class ModPathNormalizer extends Normalizer
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        if ($object instanceof Mod) {
            return [
                'path' => 'mods_show',
                'params' => ['slug' => $object->getSlug(), 'id' => $object->getId()],
            ];
        }
        throw new \RuntimeException("Can't normalize path");
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return ($data instanceof Mod)
            && PathEncoder::FORMAT === $format;
    }
}

<?php

namespace App\Http\Normalizer;

use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\Domain\Mods\Entity\Category;
use App\Infrastructure\Normalizer\Normalizer;

class CategoryListPathNormalizer extends Normalizer
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        if ($object instanceof Category) {
            return [
                'id' => $object->getId(),
                'position' => $object->getPosition(),
                'name' => $object->getName(),
                'url' => $this->urlGenerator->generate('admin_mod_category_edit', ['id' => $object->getId()]),
                'children' => $object->getChildren()->map(function (Category $tag) {
                    return $this->normalize($tag);
                })->toArray(),
            ];
        }
        throw new \RuntimeException("Can't normalize path");
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Category && 'json' === $format;
    }
}
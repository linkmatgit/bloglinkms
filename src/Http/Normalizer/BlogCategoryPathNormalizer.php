<?php

namespace App\Http\Normalizer;

use App\Domain\Blog\Entity\Category;
use App\Http\Encoder\PathEncoder;
use App\Infrastructure\Normalizer\Normalizer;

class BlogCategoryPathNormalizer extends Normalizer
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        if ($object instanceof Category) {
            return [
                'path' => 'blog_category',
                'params' => ['slug' => $object->getSlug()],
            ];
        }
        throw new \RuntimeException("Can't normalize path");
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return ($data instanceof Category)
            && PathEncoder::FORMAT === $format;
    }
}

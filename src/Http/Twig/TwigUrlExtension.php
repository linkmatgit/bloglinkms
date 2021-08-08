<?php

namespace App\Http\Twig;


use App\Domain\Application\Entity\Content;
use App\Domain\Blog\Entity\Post;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class TwigUrlExtension extends AbstractExtension {
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private UploaderHelper $uploaderHelper,
        private SerializerInterface $serializer
    ) {

    }
    public function getFunctions(): array
    {
        return [
            new TwigFunction('content_path', [$this, 'contentPath']),
            new TwigFunction('path', [$this, 'pathFor']),
            new TwigFunction('url', [$this, 'urlFor']),
        ];
    }
    public function contentPath(Content $content): ?string
    {
        if ($content instanceof Post) {
            return $this->urlGenerator->generate('blog_show', ['slug' => $content->getSlug()]);
        }

        return null;
    }
    /**
     * @param string|object $path
     */
    public function pathFor($path, array $params = []): string
    {
        if (is_string($path)) {
            return $this->urlGenerator->generate($path, $params);
        }

        return $this->serializer->serialize($path, 'path', ['url' => false]);
    }
    /**
     * @param string|object $path
     */
    public function urlFor($path, array $params = []): string
    {
        if (is_string($path)) {
            return $this->urlGenerator->generate($path, $params, \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $this->serializer->serialize($path, 'path', ['url' => true]);
    }
}
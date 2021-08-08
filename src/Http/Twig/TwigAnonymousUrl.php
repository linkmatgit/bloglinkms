<?php

namespace App\Http\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class TwigAnonymousUrl extends AbstractExtension
{


    public function getFilters(): array
    {
        return [
            new TwigFilter('autolink', [$this, 'autoLink']),
        ];
    }

    public function autoLink(string $string): string
    {
        $regexp = '/(<a.*?>)?(https?:)?(\/\/)(\w+\.)?(\w+\.[\w\/\-_.~&=?]+)(<\/a>)?/i';
        $anchor = '<a href="%s//%s" target="_blank" rel="noopener noreferrer">%s</a>';

        preg_match_all($regexp, $string, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (empty($match[1]) && empty($match[6])) {
                $protocol = $match[2] ? $match[2] : 'https:';
                $replace = sprintf($anchor, $protocol, $match[5], $match[0]);
                $string = str_replace($match[0], $replace, $string);
            }
        }

        return $string;
    }
}

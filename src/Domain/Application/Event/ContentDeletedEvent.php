<?php declare(strict_types=1);

namespace App\Domain\Application\Event;

use App\Domain\Application\Entity\Content;

class ContentDeletedEvent
{
    public function __construct(private Content $content)
    {
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }
}

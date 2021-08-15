<?php declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\Auth\User;

abstract class CommentData {

    public ?int $id = null;

    public ?string $username = null;

    public ?string $avatar = null;

    public ?int $target = null;

    public string $content = ' ';

    public ?string $email = null;

    public int $createdAt = 0;

    public ?int $parent = 0;

    public ?Comment $entity = null;

    public ?int $userId = null;

}
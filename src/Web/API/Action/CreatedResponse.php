<?php

declare(strict_types=1);

namespace App\Web\API\Action;

final class CreatedResponse extends Response
{
    public static function respond(string $id): self
    {
        return new self(['id' => $id], self::HTTP_CREATED);
    }
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action;

final class NoContentResponse extends Response
{
    public static function respond(): self
    {
        return new self([], self::HTTP_NO_CONTENT);
    }
}

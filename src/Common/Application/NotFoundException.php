<?php

declare(strict_types=1);

namespace App\Common\Application;

use Exception;
use JetBrains\PhpStorm\Pure;

final class NotFoundException extends Exception
{
    #[Pure]
    public static function notFoundById(string $id): self
    {
        return new self(sprintf('Resource not found by id `%s`', $id));
    }
}

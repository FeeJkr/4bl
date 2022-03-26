<?php

declare(strict_types=1);

namespace App\Common;

use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;

abstract class Id
{
    private function __construct(private string $id){}

    #[Pure]
    public static function fromString(?string $id): ?static
    {
        if ($id === null) {
            return null;
        }

        return new static($id);
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->id;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->toString();
    }
}

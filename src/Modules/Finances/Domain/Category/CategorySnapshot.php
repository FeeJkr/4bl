<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

final class CategorySnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly string $type,
        public readonly string $icon,
    ){}
}

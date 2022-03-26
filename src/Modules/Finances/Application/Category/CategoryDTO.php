<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use JetBrains\PhpStorm\Pure;

final class CategoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $icon,
    ){}

    #[Pure]
    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['name'],
            $row['type'],
            $row['icon'],
        );
    }
}

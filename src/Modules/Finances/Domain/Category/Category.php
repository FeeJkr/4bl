<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use App\Modules\Finances\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Category
{
    public function __construct(
        private CategoryId $id,
        private UserId $userId,
        private string $name,
        private CategoryType $type,
        private string $icon,
    ){}

    #[Pure]
    public static function new(CategoryId $id, UserId $userId, string $name, CategoryType $type, string $icon): self
    {
        return new self(
            $id,
            $userId,
            $name,
            $type,
            $icon,
        );
    }

    public function update(string $name, CategoryType $type, string $icon): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
    }

    #[Pure]
    public function getSnapshot(): CategorySnapshot
    {
        return new CategorySnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->name,
            $this->type->value,
            $this->icon,
        );
    }
}

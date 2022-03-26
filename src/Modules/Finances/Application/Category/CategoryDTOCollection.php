<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

final class CategoryDTOCollection
{
    private array $categories;

    public function __construct(CategoryDTO ...$categories)
    {
        $this->categories = $categories;
    }

    public function add(CategoryDTO $category): void
    {
        $this->categories[] = $category;
    }

    public function toArray(): array
    {
        return $this->categories;
    }
}

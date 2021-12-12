<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use App\Modules\Finances\Domain\User\UserId;

interface CategoryRepository
{
    public function store(Category $category): void;
    public function nextIdentity(): CategoryId;
    public function getById(CategoryId $id, UserId $userId): Category;
    public function delete(Category $category): void;
    public function save(Category $category): void;
}

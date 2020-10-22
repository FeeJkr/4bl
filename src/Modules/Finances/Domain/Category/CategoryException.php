<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use App\Modules\Finances\Domain\User\UserId;
use Exception;

final class CategoryException extends Exception
{
    public static function notDeleted(CategoryId $categoryId, UserId $userId): self
    {
        return new self(
            sprintf('CategoryResponse with ID %s for user %s can\'t be deleted.', $categoryId->toInt(), $userId->toInt())
        );
    }

    public static function notFound(CategoryId $categoryId, UserId $userId): self
    {
        return new self(
            sprintf('CategoryResponse with ID %s for user %s not found.', $categoryId->toInt(), $userId->toInt())
        );
    }

    public static function notFoundById(CategoryId $categoryId): self
    {
        return new self(
            sprintf('CategoryResponse with ID %s not found.', $categoryId->toInt())
        );
    }
}

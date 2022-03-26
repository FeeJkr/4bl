<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Edit;

use App\Common\Application\Command\Command;

final class EditCategoryCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $icon,
    ){}
}

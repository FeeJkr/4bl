<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Common\Application\Command\Command;

final class CreateCategoryCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $icon,
    ){}
}

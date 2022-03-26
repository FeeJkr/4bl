<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

enum CategoryType: string
{
    case EXPENSES = 'expenses';
    case INCOME = 'income';
}

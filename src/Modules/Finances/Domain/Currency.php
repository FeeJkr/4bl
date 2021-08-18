<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static Currency PLN()
 */
final class Currency extends Enum
{
    private const PLN = 'PLN';
}
<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain;

final class Money
{
    public function __construct(public readonly int $value, public readonly Currency $currency){}
}

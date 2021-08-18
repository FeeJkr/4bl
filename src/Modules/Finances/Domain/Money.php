<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain;

final class Money
{
    public function __construct(private int $value, private Currency $currency){}

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
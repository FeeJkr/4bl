<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

final class WalletDTOCollection
{
    public function __construct(private array $elements = []){}

    public function add(WalletDTO $wallet): void
    {
        $this->elements[] = $wallet;
    }

    public function toArray(): array
    {
        return $this->elements;
    }
}
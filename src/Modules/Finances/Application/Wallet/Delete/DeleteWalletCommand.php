<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

use App\Common\Application\Command\Command;

final class DeleteWalletCommand implements Command
{
    public function __construct(private string $id){}

    public function getId(): string
    {
        return $this->id;
    }
}
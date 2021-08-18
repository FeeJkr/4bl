<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetById;

use App\Common\Application\Query\Query;

final class GetWalletByIdQuery implements Query
{
    public function __construct(private string $id){}

    public function getId(): string
    {
        return $this->id;
    }
}
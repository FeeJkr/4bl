<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Contractor;

final class ContractorSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $addressId,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}
}

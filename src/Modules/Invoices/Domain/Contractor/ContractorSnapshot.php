<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Contractor;

use App\Modules\Invoices\Domain\Address\AddressSnapshot;

final class ContractorSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly AddressSnapshot $address,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}
}

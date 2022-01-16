<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor;

use JetBrains\PhpStorm\Pure;

final class ContractorDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $addressId,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}

    #[Pure]
    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            $storage['invoices_addresses_id'],
            $storage['name'],
            $storage['identification_number'],
        );
    }
}

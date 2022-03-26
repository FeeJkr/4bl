<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor;

use App\Modules\Invoices\Application\Address\AddressDTO;
use JetBrains\PhpStorm\Pure;

final class ContractorDTO
{
    public function __construct(
        public readonly string $id,
        public readonly AddressDTO $address,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}

    #[Pure]
    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            AddressDTO::createFromRow([
                'id' => $storage['address_id'],
                'name' => $storage['address_name'],
                'street' => $storage['address_street'],
                'city' => $storage['address_city'],
                'zip_code' => $storage['address_zip_code'],
            ]),
            $storage['name'],
            $storage['identification_number'],
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address;

final class AddressDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}

    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            $storage['name'],
            $storage['street'],
            $storage['zip_code'],
            $storage['city'],
        );
    }
}

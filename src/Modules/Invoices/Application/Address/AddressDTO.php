<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address;

use JetBrains\PhpStorm\Pure;

final class AddressDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}

    #[Pure]
    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['name'],
            $row['street'],
            $row['city'],
            $row['zip_code'],
        );
    }
}

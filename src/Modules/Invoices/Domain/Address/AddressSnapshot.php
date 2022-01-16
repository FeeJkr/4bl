<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Address;

final class AddressSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}
}

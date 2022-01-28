<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

final class AddressDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}
}

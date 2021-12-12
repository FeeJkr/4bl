<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanyAddressSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}
}

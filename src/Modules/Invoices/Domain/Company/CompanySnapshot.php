<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanySnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $addressId,
        public readonly ?string $paymentInformationId,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
    ){}
}

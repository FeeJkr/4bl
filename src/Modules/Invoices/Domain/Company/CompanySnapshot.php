<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\Address\AddressSnapshot;

final class CompanySnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly AddressSnapshot $address,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $vatRejectionReason,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
    ){}
}

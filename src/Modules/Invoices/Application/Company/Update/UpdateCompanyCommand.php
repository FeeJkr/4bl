<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Update;

use App\Common\Application\Command\Command;

final class UpdateCompanyCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $vatRejectionReason,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}
}

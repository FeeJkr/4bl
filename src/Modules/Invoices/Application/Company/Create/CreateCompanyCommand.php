<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\Command;
use App\Modules\Invoices\Application\Company\ContactInformationDTO;
use App\Modules\Invoices\Application\Company\VatInformationDTO;

final class CreateCompanyCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly string $addressId,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $reason,
    ){}
}

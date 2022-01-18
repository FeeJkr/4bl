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
        public readonly ContactInformationDTO $contactInformation,
        public readonly VatInformationDTO $vatInformationDTO,
    ){}
}

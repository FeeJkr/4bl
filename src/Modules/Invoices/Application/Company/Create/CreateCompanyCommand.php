<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\Command;

final class CreateCompanyCommand implements Command
{
    public function __construct(
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
    ){}
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Create;

use App\Common\Application\Command\Command;

final class CreateContractorCommand implements Command
{
    public function __construct(
        public readonly string $addressId,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}
}

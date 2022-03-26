<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Update;

use App\Common\Application\Command\Command;

final class UpdateContractorCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\Update;

use App\Common\Application\Command\Command;

final class UpdateAddressCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}
}

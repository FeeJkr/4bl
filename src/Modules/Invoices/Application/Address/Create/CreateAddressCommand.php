<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\Create;

use App\Common\Application\Command\Command;

final class CreateAddressCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

final class ContactInformationDTO
{
    public function __construct(
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
    ){}
}

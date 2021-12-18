<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\Company\Assign;

use App\Common\Application\Command\Command;

final class AssignCompanyToAccountCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly string $languageCode,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
        public readonly ?string $phoneNumber,
        public readonly ?string $email,
        public readonly string $bank,
        public readonly string $accountNumber,
    ){}
}

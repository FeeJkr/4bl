<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\UpdatePaymentInformation;

use App\Common\Application\Command\Command;

final class UpdateCompanyPaymentInformationCommand implements Command
{
    public function __construct(
        public readonly string $companyId,
        public readonly string $paymentType,
        public readonly int $paymentLastDate,
        public readonly string $bank,
        public readonly string $accountNumber,
    ){}
}

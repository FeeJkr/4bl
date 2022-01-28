<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\Command;

final class UpdateInvoiceCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $invoiceNumber,
        public readonly string $generatePlace,
        public readonly float $alreadyTakenPrice,
        public readonly int $daysForPayment,
        public readonly string $paymentType,
        public readonly ?string $bankAccountId,
        public readonly string $currencyCode,
        public readonly string $companyId,
        public readonly string $contractorId,
        public readonly string $generatedAt,
        public readonly string $soldAt,
        public readonly array $products,
    ){}
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\BankAccount\BankAccountId;

final class PaymentParameters
{
    public function __construct(
        public readonly int $daysForPayment,
        public readonly PaymentType $paymentType,
        public readonly ?BankAccountId $bankAccountId,
        public readonly string $currencyCode,
    ){}
}

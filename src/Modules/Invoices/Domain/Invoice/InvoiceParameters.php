<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

final class InvoiceParameters
{
    public function __construct(
        private string $invoiceNumber,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private PaymentParameters $paymentParameters,
        private DateTimeImmutable $generatedAt,
        private DateTimeImmutable $soldAt,
    ){}

    #[Pure]
    public function getSnapshot(): InvoiceParametersSnapshot
    {
        return new InvoiceParametersSnapshot(
            $this->invoiceNumber,
            $this->generatePlace,
            $this->alreadyTakenPrice,
            $this->paymentParameters->daysForPayment,
            $this->paymentParameters->paymentType->value,
            $this->paymentParameters->bankAccountId?->toString(),
            $this->paymentParameters->currencyCode,
            $this->generatedAt,
            $this->soldAt,
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

class InvoiceParameters
{
    public function __construct(
        private string $invoiceNumber,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private string $currencyCode,
        private int $vatPercentage,
        private DateTimeImmutable $generateDate,
        private DateTimeImmutable $sellDate,
    ){}

    #[Pure]
    public function getSnapshot(): InvoiceParametersSnapshot
    {
        return new InvoiceParametersSnapshot(
            $this->invoiceNumber,
            $this->generatePlace,
            $this->alreadyTakenPrice,
            $this->currencyCode,
            $this->vatPercentage,
            $this->generateDate,
            $this->sellDate,
        );
    }
}
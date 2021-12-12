<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\Command;

final class UpdateInvoiceCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $invoiceNumber,
        public readonly string $generateDate,
        public readonly string $sellDate,
        public readonly string $generatePlace,
        public readonly string $sellerId,
        public readonly string $buyerId,
        public readonly array $products,
        public readonly float $alreadyTakenPrice,
        public readonly string $currency,
        public readonly int $vatPercentage,
    ){}
}

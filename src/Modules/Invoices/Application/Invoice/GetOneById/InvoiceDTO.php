<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use DateTimeImmutable;

final class InvoiceDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $companyId,
        public readonly string $contractorId,
        public readonly string $invoiceNumber,
        public readonly string $generatePlace,
        public readonly float $alreadyTakenPrice,
        public readonly int $daysForPayment,
        public readonly string $paymentType,
        public readonly string $bankAccountId,
        public readonly string $currencyCode,
        public readonly DateTimeImmutable $generatedAt,
        public readonly DateTimeImmutable $soldAt,
        public readonly InvoiceProductsCollection $products,
    ){}

    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            $storage['users_id'],
            $storage['invoices_companies_id'],
            $storage['invoices_contractors_id'],
            $storage['invoice_number'],
            $storage['generate_place'],
            (float) $storage['already_taken_price'],
            (int) $storage['days_for_payment'],
            $storage['payment_type'],
            $storage['invoices_bank_accounts_id'],
            $storage['currency_code'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $storage['generated_at']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $storage['sold_at']),
            new InvoiceProductsCollection(
                ...array_map(static fn (array $row) => InvoiceProductDTO::fromStorage($row), $storage['products'])
            )
        );
    }
}

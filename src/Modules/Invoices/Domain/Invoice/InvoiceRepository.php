<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\User\UserId;

interface InvoiceRepository
{
    public function store(Invoice $invoice): void;
    public function save(Invoice $invoice): void;
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice;
    public function delete(Invoice $invoice): void;
}

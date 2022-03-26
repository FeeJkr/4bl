<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\User\UserId;

interface InvoiceRepository
{
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice;

    public function store(InvoiceSnapshot $invoice): void;
    public function save(InvoiceSnapshot $invoice): void;
    public function delete(InvoiceId $id, UserId $userId): void;
}

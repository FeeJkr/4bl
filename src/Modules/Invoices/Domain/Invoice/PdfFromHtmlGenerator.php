<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

interface PdfFromHtmlGenerator
{
    public function generate(InvoiceSnapshot $snapshot): void;
}

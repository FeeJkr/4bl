<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetAll;

use App\Modules\Invoices\Application\Invoice\GetAll\InvoiceDTO;
use App\Modules\Invoices\Application\Invoice\GetAll\InvoicesCollection;
use App\Web\API\Action\Response;

final class GetAllInvoicesResponse extends Response
{
    public static function respond(InvoicesCollection $invoices): self
    {
        return new self(
            array_map(static fn (InvoiceDTO $invoice) => [
                'id' => $invoice->id,
                'invoiceNumber' => $invoice->invoiceNumber,
                'generatedAt' => $invoice->generatedAt->format('d-m-Y'),
                'soldAt' => $invoice->soldAt->format('d-m-Y'),
                'status' => $invoice->status,
                'companyName' => $invoice->companyName,
                'contractorName' => $invoice->contractorName,
                'totalNetPrice' => $invoice->totalNetPrice,
                'totalGrossPrice' => $invoice->totalGrossPrice,
                'currencyCode' => $invoice->currencyCode,
            ], $invoices->items)
        );
    }
}

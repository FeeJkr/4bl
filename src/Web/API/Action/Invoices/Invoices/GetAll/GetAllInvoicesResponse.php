<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetAll;

use App\Modules\Invoices\Application\Invoice\GetAll\InvoiceDTO;
use App\Modules\Invoices\Application\Invoice\GetAll\InvoiceDTOCollection;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Web\API\Action\Response;
use Doctrine\Common\Collections\Collection;

final class GetAllInvoicesResponse extends Response
{
    public static function respond(InvoiceDTOCollection $invoices): self
    {
        return new self(array_map(static fn (InvoiceDTO $invoice) => [
            'id' => $invoice->id,
            'invoiceNumber' => $invoice->invoiceNumber,
            'generatedAt' => $invoice->generatedAt->format('Y-m-d'),
            'soldAt' => $invoice->soldAt->format('Y-m-d'),
            'sellerName' => $invoice->sellerName,
            'buyerName' => $invoice->buyerName,
            'totalNetPrice' => $invoice->totalNetPrice,
            'currencyCode' => $invoice->currencyCode,
            'vatPercentage' => $invoice->vatPercentage,
        ], $invoices->toArray()));
    }
}

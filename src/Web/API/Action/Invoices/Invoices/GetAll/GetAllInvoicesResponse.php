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
            'id' => $invoice->getId(),
            'invoiceNumber' => $invoice->getInvoiceNumber(),
            'generatedAt' => $invoice->getGeneratedAt()->format('Y-m-d'),
            'soldAt' => $invoice->getSoldAt()->format('Y-m-d'),
            'sellerName' => $invoice->getSellerName(),
            'buyerName' => $invoice->getBuyerName(),
            'totalNetPrice' => $invoice->getTotalNetPrice(),
            'currencyCode' => $invoice->getCurrencyCode(),
            'vatPercentage' => $invoice->getVatPercentage(),
        ], $invoices->toArray()));
    }
}
<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetOneById;

use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceDTO;
use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceProductDTO;
use App\Web\API\Action\Response;

final class GetOneInvoiceByIdResponse extends Response
{
    public static function respond(InvoiceDTO $invoice): self
    {
        return new self([
            'id' => $invoice->id,
            'userId' => $invoice->userId,
            'companyId' => $invoice->companyId,
            'contractorId' => $invoice->contractorId,
            'invoiceNumber' => $invoice->invoiceNumber,
            'generatePlace' => $invoice->generatePlace,
            'alreadyTakenPrice' => $invoice->alreadyTakenPrice,
            'daysForPayment' => $invoice->daysForPayment,
            'paymentType' => $invoice->paymentType,
            'bankAccountId' => $invoice->bankAccountId,
            'currencyCode' => $invoice->currencyCode,
            'generatedAt' => $invoice->generatedAt,
            'soldAt' => $invoice->soldAt,
            'products' => array_map(static fn (InvoiceProductDTO $product) => [
                'id' => $product->id,
                'position' => $product->position,
                'name' => $product->name,
                'unit' => $product->unit,
                'quantity' => $product->quantity,
                'net_price' => $product->netPrice,
                'gross_price' => $product->grossPrice,
                'tax' => $product->taxPercentage,
            ], $invoice->products->items),
        ]);
    }
}

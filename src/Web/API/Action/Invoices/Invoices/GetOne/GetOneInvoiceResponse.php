<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetOne;

use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceDTO;
use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceProductDTO;
use App\Modules\Invoices\Application\Invoice\GetOneById\InvoiceProductDTOCollection;
use App\Web\API\Action\Response;

final class GetOneInvoiceResponse extends Response
{
    public static function respond(InvoiceDTO $invoice): self
    {
        return new self([
            'id' => $invoice->id,
            'userId' => $invoice->userId,
            'sellerId' => $invoice->sellerId,
            'buyerId' => $invoice->buyerId,
            'invoiceNumber' => $invoice->invoiceNumber,
            'alreadyTakenPrice' => $invoice->alreadyTakenPrice,
            'generatePlace' => $invoice->generatePlace,
            'currencyCode' => $invoice->currencyCode,
            'vatPercentage' => $invoice->vatPercentage,
            'generatedAt' => $invoice->generatedAt->format('d-m-Y'),
            'soldAt' => $invoice->soldAt->format('d-m-Y'),
            'products' => self::buildProducts($invoice->products),
        ]);
    }

    private static function buildProducts(InvoiceProductDTOCollection $products): array
    {
        return array_map(
            static fn(InvoiceProductDTO $product) => [
                'position' => $product->position,
                'name' => $product->name,
                'price' => $product->price,
            ],
            $products->toArray()
        );
    }
}

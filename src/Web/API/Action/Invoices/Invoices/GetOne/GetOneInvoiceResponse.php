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
            'id' => $invoice->getId(),
            'userId' => $invoice->getUserId(),
            'sellerId' => $invoice->getSellerId(),
            'buyerId' => $invoice->getBuyerId(),
            'invoiceNumber' => $invoice->getInvoiceNumber(),
            'alreadyTakenPrice' => $invoice->getAlreadyTakenPrice(),
            'generatePlace' => $invoice->getGeneratePlace(),
            'currencyCode' => $invoice->getCurrencyCode(),
            'generatedAt' => $invoice->getGeneratedAt()->format('d-m-Y'),
            'soldAt' => $invoice->getSoldAt()->format('d-m-Y'),
            'products' => self::buildProducts($invoice->getProducts()),
        ]);
    }

    private static function buildProducts(InvoiceProductDTOCollection $products): array
    {
        return array_map(
            static fn(InvoiceProductDTO $product) => [
                'position' => $product->getPosition(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ],
            $products->toArray()
        );
    }
}
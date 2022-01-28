<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetAll\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductSnapshot;
use App\Modules\Invoices\Domain\Invoice\InvoiceSnapshot;
use DateInterval;
use RuntimeException;
use Throwable;

final class TwigHtmlGenerator
{
    public function __construct(
        private PriceTransformer $priceTransformer,
        private QueryBus         $queryBus
    ){}

    public function prepareParameters(InvoiceSnapshot $snapshot): array
    {
        try {
            /** @var CompanyDTO $seller */
            $seller = $this->queryBus->handle(new GetOneCompanyByIdQuery($snapshot->sellerId));

            /** @var CompanyDTO $buyer */
            $buyer = $this->queryBus->handle(new GetOneCompanyByIdQuery($snapshot->buyerId));
            $paymentLastDate = clone $snapshot->parameters->sellDate;
            $paymentLastDate->add(new DateInterval(sprintf('P%dD', $seller->paymentLastDate)));
            $toPayPrice = $this->calculateToPayPrice($snapshot);

            return [
                'invoiceNumber' => $snapshot->parameters->invoiceNumber,
                'generateDate' => $snapshot->parameters->generateDate->format('d-m-Y'),
                'sellDate' => $snapshot->parameters->sellDate->format('d-m-Y'),
                'generatePlace' => $snapshot->parameters->generatePlace,
                'seller' => [
                    'name' => $seller->name,
                    'street' => $seller->street,
                    'zipCode' => $seller->zipCode,
                    'city' => $seller->city,
                    'identificationNumber' => $seller->identificationNumber,
                    'email' => $seller->email,
                    'phoneNumber' => $seller->phoneNumber,
                ],
                'buyer' => [
                    'name' => $buyer->name,
                    'street' => $buyer->street,
                    'zipCode' => $buyer->zipCode,
                    'city' => $buyer->city,
                    'identificationNumber' => $buyer->identificationNumber,
                    'email' => $buyer->email,
                    'phoneNumber' => $buyer->phoneNumber,
                ],
                'products' => $this->prepareProducts($snapshot->products),
                'totalNetPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getNetPrice(),
                        $snapshot->products
                    )
                ),
                'totalTaxPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getTaxPrice(),
                        $snapshot->products
                    )
                ),
                'totalGrossPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getGrossPrice(),
                        $snapshot->products
                    )
                ),
                'paymentType' => $seller->paymentType,
                'paymentLastDate' => $snapshot
                    ->parameters
                    ->sellDate
                    ->modify('+' . $seller->paymentLastDate . ' days')
                    ->format('d-m-Y'),
                'paymentBankName' => $seller->bank,
                'paymentAccountNumber' => $seller->accountNumber,
                'alreadyTakenPrice' => $snapshot->parameters->alreadyTakenPrice,
                'toPayPrice' => $toPayPrice,
                'currencyCode' => $snapshot->parameters->currencyCode,
                'translatePrice' => $this->priceTransformer->transformToText($toPayPrice),
                'vatPercentage' => $snapshot->parameters->vatPercentage,
            ];
        } catch (Throwable $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    private function calculateToPayPrice(InvoiceSnapshot $snapshot): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProductSnapshot $product): float => $product->getGrossPrice(),
                $snapshot->products
            )
        ) - $snapshot->parameters->alreadyTakenPrice;
    }

    private function prepareProducts(array $collection): array
    {
        return array_map(static fn(InvoiceProductSnapshot $product): array => [
            'name' => $product->getName(),
            'netPrice' => $product->getNetPrice(),
            'taxPrice' => $product->getTaxPrice(),
            'grossPrice' => $product->getGrossPrice(),
        ], $collection);
    }
}

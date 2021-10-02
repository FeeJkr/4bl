<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Invoices\Domain\Invoice\HtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductSnapshot;
use App\Modules\Invoices\Domain\Invoice\InvoiceSnapshot;
use App\Modules\Invoices\Domain\Invoice\PriceTransformer;
use DateInterval;
use Doctrine\Common\Collections\Collection;
use Exception;
use Throwable;
use Twig\Environment;

class TwigHtmlGenerator implements HtmlGenerator
{
    public function __construct(
        private PriceTransformer $priceTransformer,
        private QueryBus $queryBus
    ){}

    public function prepareParameters(InvoiceSnapshot $snapshot): array
    {
        try {
            /** @var CompanyDTO $seller */
            $seller = $this->queryBus->handle(new GetOneCompanyByIdQuery($snapshot->getSellerId()));

            /** @var CompanyDTO $buyer */
            $buyer = $this->queryBus->handle(new GetOneCompanyByIdQuery($snapshot->getBuyerId()));
            $paymentLastDate = clone $snapshot->getParameters()->getSellDate();
            $paymentLastDate->add(new DateInterval(sprintf('P%dD', $seller->getPaymentLastDate())));
            $toPayPrice = $this->calculateToPayPrice($snapshot);

            return [
                'invoiceNumber' => $snapshot->getParameters()->getInvoiceNumber(),
                'generateDate' => $snapshot->getParameters()->getGenerateDate()->format('d-m-Y'),
                'sellDate' => $snapshot->getParameters()->getSellDate()->format('d-m-Y'),
                'generatePlace' => $snapshot->getParameters()->getGeneratePlace(),
                'seller' => [
                    'name' => $seller->getName(),
                    'street' => $seller->getStreet(),
                    'zipCode' => $seller->getZipCode(),
                    'city' => $seller->getCity(),
                    'identificationNumber' => $seller->getIdentificationNumber(),
                    'email' => $seller->getEmail(),
                    'phoneNumber' => $seller->getPhoneNumber(),
                ],
                'buyer' => [
                    'name' => $buyer->getName(),
                    'street' => $buyer->getStreet(),
                    'zipCode' => $buyer->getZipCode(),
                    'city' => $buyer->getCity(),
                    'identificationNumber' => $buyer->getIdentificationNumber(),
                    'email' => $buyer->getEmail(),
                    'phoneNumber' => $buyer->getPhoneNumber(),
                ],
                'products' => $this->prepareProducts($snapshot->getProducts()),
                'totalNetPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getNetPrice(),
                        $snapshot->getProducts()
                    )
                ),
                'totalTaxPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getTaxPrice(),
                        $snapshot->getProducts()
                    )
                ),
                'totalGrossPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->getGrossPrice(),
                        $snapshot->getProducts()
                    )
                ),
                'paymentType' => $seller->getPaymentType(),
                'paymentLastDate' => $snapshot
                    ->getParameters()
                    ->getSellDate()
                    ->modify('+' . $seller->getPaymentLastDate() . ' days')
                    ->format('d-m-Y'),
                'paymentBankName' => $seller->getBank(),
                'paymentAccountNumber' => $seller->getAccountNumber(),
                'alreadyTakenPrice' => $snapshot->getParameters()->getAlreadyTakenPrice(),
                'toPayPrice' => $toPayPrice,
                'currencyCode' => $snapshot->getParameters()->getCurrencyCode(),
                'translatePrice' => $this->priceTransformer->transformToText($toPayPrice),
            ];
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    private function calculateToPayPrice(InvoiceSnapshot $snapshot): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProductSnapshot $product): float => $product->getGrossPrice(),
                $snapshot->getProducts()
            )
        ) - $snapshot->getParameters()->getAlreadyTakenPrice();
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
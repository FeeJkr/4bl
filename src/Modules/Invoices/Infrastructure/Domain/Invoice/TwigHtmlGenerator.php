<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Invoices\Domain\Invoice\HtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\PriceTransformer;
use DateInterval;
use Doctrine\Common\Collections\Collection;
use Exception;
use Throwable;
use Twig\Environment;

class TwigHtmlGenerator implements HtmlGenerator
{
    public function __construct(
        private PriceTransformer $priceTransformer
    ){}

    public function prepareParameters(Invoice $invoice): array
    {
        try {
            $seller = $invoice->getSeller();
            $buyer = $invoice->getBuyer();
            $paymentLastDate = clone $invoice->getParameters()->getSellDate();
            $paymentLastDate->add(new DateInterval(sprintf('P%dD', $seller->getPaymentLastDate())));
            $toPayPrice = $this->calculateToPayPrice($invoice);

            return [
                'invoiceNumber' => $invoice->getParameters()->getInvoiceNumber(),
                'generateDate' => $invoice->getParameters()->getGenerateDate()->format('d-m-Y'),
                'sellDate' => $invoice->getParameters()->getSellDate()->format('d-m-Y'),
                'generatePlace' => $invoice->getParameters()->getGeneratePlace(),
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
                'products' => $this->prepareProducts($invoice->getProducts()),
                'totalNetPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProduct $product): float => $product->getNetPrice(),
                        $invoice->getProducts()->toArray()
                    )
                ),
                'totalTaxPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProduct $product): float => $product->getTaxPrice(),
                        $invoice->getProducts()->toArray()
                    )
                ),
                'totalGrossPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProduct $product): float => $product->getGrossPrice(),
                        $invoice->getProducts()->toArray()
                    )
                ),
                'paymentType' => $seller->getPaymentType(),
                'paymentLastDate' => $paymentLastDate->format('d-m-Y'),
                'paymentBankName' => $seller->getBank(),
                'paymentAccountNumber' => $seller->getAccountNumber(),
                'alreadyTakenPrice' => $invoice->getParameters()->getAlreadyTakenPrice(),
                'toPayPrice' => $toPayPrice,
                'currencyCode' => $invoice->getParameters()->getCurrencyCode(),
                'translatePrice' => $this->priceTransformer->transformToText($toPayPrice),
            ];
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    private function calculateToPayPrice(Invoice $invoice): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProduct $product): float => $product->getGrossPrice(),
                $invoice->getProducts()->toArray()
            )
        ) - $invoice->getParameters()->getAlreadyTakenPrice();
    }

    private function prepareProducts(Collection $collection): array
    {
        return $collection->map(fn(InvoiceProduct $product): array => [
            'name' => $product->getName(),
            'netPrice' => $product->getNetPrice(),
            'taxPrice' => $product->getTaxPrice(),
            'grossPrice' => $product->getGrossPrice(),
        ])->toArray();
    }
}
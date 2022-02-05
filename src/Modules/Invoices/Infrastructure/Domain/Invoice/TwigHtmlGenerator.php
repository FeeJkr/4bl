<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\BankAccount\BankAccountDTO;
use App\Modules\Invoices\Application\BankAccount\GetOneById\GetOneBankAccountByIdQuery;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Application\Contractor\GetOneById\GetOneContractorByIdQuery;
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
            /** @var CompanyDTO $company */
            $company = $this->queryBus->handle(new GetOneCompanyByIdQuery($snapshot->companyId));
            /** @var ContractorDTO $contractor */
            $contractor = $this->queryBus->handle(new GetOneContractorByIdQuery($snapshot->contractorId));
            /** @var BankAccountDTO $bankAccount */
            $bankAccount = $this->queryBus->handle(new GetOneBankAccountByIdQuery($snapshot->parameters->bankAccountId));

            $paymentLastDate = clone $snapshot->parameters->soldAt;
            $paymentLastDate->add(new DateInterval(sprintf('P%dD', $snapshot->parameters->daysForPayment)));
            $toPayPrice = $this->calculateToPayPrice($snapshot);

            return [
                'invoiceNumber' => $snapshot->parameters->invoiceNumber,
                'generatedAt' => $snapshot->parameters->generatedAt->format('d-m-Y'),
                'soldAt' => $snapshot->parameters->soldAt->format('d-m-Y'),
                'generatePlace' => $snapshot->parameters->generatePlace,
                'company' => [
                    'name' => $company->name,
                    'street' => $company->address->street,
                    'zipCode' => $company->address->zipCode,
                    'city' => $company->address->city,
                    'identificationNumber' => $company->identificationNumber,
                    'email' => $company->email,
                    'phoneNumber' => $company->phoneNumber,
                    'isVatPayer' => $company->isVatPayer,
                    'vatRejectionReason' => $company->vatRejectionReason,
                ],
                'contractor' => [
                    'name' => $contractor->name,
                    'street' => $contractor->address->street,
                    'zipCode' => $contractor->address->zipCode,
                    'city' => $contractor->address->city,
                    'identificationNumber' => $contractor->identificationNumber,
                ],
                'products' => $this->prepareProducts($snapshot->products),
                'totalNetPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->netPrice,
                        $snapshot->products
                    )
                ),
                'totalTaxPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->taxPrice,
                        $snapshot->products
                    )
                ),
                'totalGrossPrice' => array_sum(
                    array_map(
                        static fn (InvoiceProductSnapshot $product): float => $product->grossPrice,
                        $snapshot->products
                    )
                ),
                'paymentType' => $snapshot->parameters->paymentType,
                'paymentLastDate' => $snapshot
                    ->parameters
                    ->soldAt
                    ->modify('+' . $snapshot->parameters->daysForPayment . ' days')
                    ->format('d-m-Y'),
                'paymentBankName' => $bankAccount->bankName,
                'paymentAccountNumber' => $bankAccount->bankAccountNumber,
                'alreadyTakenPrice' => $snapshot->parameters->alreadyTakenPrice,
                'toPayPrice' => $toPayPrice,
                'currencyCode' => $snapshot->parameters->currencyCode,
                'translatePrice' => $this->priceTransformer->transformToText($toPayPrice),
            ];
        } catch (Throwable $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    private function calculateToPayPrice(InvoiceSnapshot $snapshot): float
    {
        return array_sum(
            array_map(
                static fn (InvoiceProductSnapshot $product): float => $product->grossPrice,
                $snapshot->products
            )
        ) - $snapshot->parameters->alreadyTakenPrice;
    }

    private function prepareProducts(array $collection): array
    {
        return array_map(static fn(InvoiceProductSnapshot $product): array => [
            'name' => $product->name,
            'unit' => $product->unit,
            'quantity' => $product->quantity,
            'netPrice' => $product->netPrice,
            'taxPrice' => $product->taxPrice,
            'grossPrice' => $product->grossPrice,
            'tax' => $product->tax,
        ], $collection);
    }
}

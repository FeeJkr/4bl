<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Generate;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use App\Modules\Invoices\Domain\Invoice\PaymentParameters;
use App\Modules\Invoices\Domain\Invoice\PaymentType;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\Tax;
use App\Modules\Invoices\Domain\Invoice\Unit;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;

final class GenerateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $invoiceRepository,
        private UserContext $userContext,
    ){}

    public function __invoke(GenerateInvoiceCommand $command): string
    {
        $invoiceParameters = new InvoiceParameters(
                $command->invoiceNumber,
                $command->generatePlace,
                $command->alreadyTakenPrice,
                new PaymentParameters(
                    $command->daysForPayment,
                    PaymentType::from($command->paymentType),
                    BankAccountId::fromString($command->bankAccountId),
                    $command->currencyCode,
                ),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->generatedAt),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->soldAt),
        );

        $userId = $this->userContext->getUserId();

        $invoice = Invoice::create(
            $userId,
            CompanyId::fromString($command->companyId),
            ContractorId::fromString($command->contractorId),
            $invoiceParameters,
            $this->prepareProducts($command->products),
        );

        $this->invoiceRepository->store($invoice->snapshot());

        return $invoice->snapshot()->id;
    }

    private function prepareProducts(array $products): InvoiceProductsCollection
    {
        return new InvoiceProductsCollection(
            ...array_map(
                static fn (array $product) => new InvoiceProduct(
                    InvoiceProductId::generate(),
                    (int) $product['position'],
                    $product['name'],
                    Unit::from($product['unit']),
                    (int) $product['quantity'],
                    (float) $product['netPrice'],
                    Tax::from((int) $product['tax']),
                ),
                $products
            )
        );
    }
}

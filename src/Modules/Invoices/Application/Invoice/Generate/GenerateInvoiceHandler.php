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
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
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
        private CompanyRepository $companyRepository,
        private UserContext $userContext,
    ){}

    public function __invoke(GenerateInvoiceCommand $command): void
    {
        $invoiceParameters = new InvoiceParameters(
                $command->invoiceNumber,
                $command->generatePlace,
                $command->alreadyTakenPrice,
                new PaymentParameters(
                    $command->daysForPayment,
                    PaymentType::from($command->paymentType),
                    $command->bankAccountId ? BankAccountId::fromString($command->bankAccountId) : null,
                    $command->currencyCode,
                ),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->generatedAt),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->soldAt),
        );

        $userId = $this->userContext->getUserId();
        $company = $this->companyRepository->fetchByUserId($userId);

        $invoice = Invoice::create(
            $userId,
            CompanyId::fromString($company->snapshot()->id),
            ContractorId::fromString($command->contractorId),
            $invoiceParameters,
            $this->prepareProducts($command->products),
        );

        $this->invoiceRepository->store($invoice);
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
                    (float) $product['net_price'],
                    Tax::from((int) $product['tax']),
                ),
                $products
            )
        );
    }
}

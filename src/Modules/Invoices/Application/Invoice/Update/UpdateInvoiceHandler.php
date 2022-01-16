<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\PaymentParameters;
use App\Modules\Invoices\Domain\Invoice\PaymentType;
use App\Modules\Invoices\Domain\Invoice\Tax;
use App\Modules\Invoices\Domain\Invoice\Unit;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;

final class UpdateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(UpdateInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->id),
            $this->userContext->getUserId(),
        );

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

        $invoice->update(
            ContractorId::fromString($command->contractorId),
            $invoiceParameters,
            $this->prepareProducts($command->products),
        );

        $this->repository->save($invoice->snapshot());
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

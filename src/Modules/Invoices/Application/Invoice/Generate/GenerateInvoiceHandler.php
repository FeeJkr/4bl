<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Generate;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;

final class GenerateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
        private UserContext $userContext,
    ){}

    public function __invoke(GenerateInvoiceCommand $command): void
    {
        $invoiceParameters = new InvoiceParameters(
                $command->invoiceNumber,
                $command->generatePlace,
                $command->alreadyTakenPrice,
                $command->currency,
                $command->vatPercentage,
                DateTimeImmutable::createFromFormat('d-m-Y', $command->generateDate),
                DateTimeImmutable::createFromFormat('d-m-Y', $command->sellDate),
        );

        $userId = $this->userContext->getUserId();

        $invoice = Invoice::create(
            $userId,
            CompanyId::fromString($command->sellerId),
            CompanyId::fromString($command->buyerId),
            $invoiceParameters,
            InvoiceProductsCollection::fromArray($command->products, $command->vatPercentage),
        );

        $this->pdfFromHtmlGenerator->generate($invoice->getSnapshot());

        $this->repository->store($invoice);
    }
}

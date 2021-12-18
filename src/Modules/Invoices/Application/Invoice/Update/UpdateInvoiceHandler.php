<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;

final class UpdateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private UserContext $userContext,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
    ){}

    public function __invoke(UpdateInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->id),
            $this->userContext->getUserId()
        );

        $invoiceParameters = new InvoiceParameters(
            $command->invoiceNumber,
            $command->generatePlace,
            $command->alreadyTakenPrice,
            $command->currency,
            $command->vatPercentage,
            DateTimeImmutable::createFromFormat('d-m-Y', $command->generateDate),
            DateTimeImmutable::createFromFormat('d-m-Y', $command->sellDate),
        );

        $invoice->update(
            CompanyId::fromString($command->sellerId),
            CompanyId::fromString($command->buyerId),
            $invoiceParameters,
            InvoiceProductsCollection::fromArray($command->products, $command->vatPercentage)
        );

        $this->pdfFromHtmlGenerator->generate($invoice->getSnapshot());

        $this->repository->save($invoice);
    }
}

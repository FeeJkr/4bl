<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTime;
use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

class UpdateInvoiceHandler implements CommandHandler
{
    public function __construct(
        private InvoiceRepository $repository,
        private UserContext $userContext,
        private PdfFromHtmlGenerator $pdfFromHtmlGenerator,
    ){}

    public function __invoke(UpdateInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->getId()),
            $this->userContext->getUserId()
        );

        $invoiceParameters = new InvoiceParameters(
            $command->getInvoiceNumber(),
            $command->getGeneratePlace(),
            $command->getAlreadyTakenPrice(),
            $command->getCurrency(),
            $command->getVatPercentage(),
            DateTimeImmutable::createFromFormat('d-m-Y', $command->getGenerateDate()),
            DateTimeImmutable::createFromFormat('d-m-Y', $command->getSellDate()),
        );

        $invoice->update(
            CompanyId::fromString($command->getSellerId()),
            CompanyId::fromString($command->getBuyerId()),
            $invoiceParameters,
            InvoiceProductsCollection::fromArray($command->getProducts(), $command->getVatPercentage())
        );

        $this->pdfFromHtmlGenerator->generate($invoice->getSnapshot());

        $this->repository->save($invoice);
    }
}
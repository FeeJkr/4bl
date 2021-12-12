<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class DeleteInvoiceHandler implements CommandHandler
{
    public function __construct(private InvoiceRepository $repository, private UserContext $userContext){}

    public function __invoke(DeleteInvoiceCommand $command): void
    {
        $invoice = $this->repository->fetchOneById(
            InvoiceId::fromString($command->invoiceId),
            $this->userContext->getUserId()
        );

        $this->repository->delete($invoice);
    }
}

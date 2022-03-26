<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Event;

use App\Common\Application\Event\EventHandler;
use App\Modules\Invoices\Domain\Invoice\Event\InvoiceWasCreated;
use App\Modules\Invoices\Infrastructure\Domain\Invoice\PdfFromHtmlGenerator;

class GenerateInvoicePDF implements EventHandler
{
    public function __construct(private PdfFromHtmlGenerator $generator){}

    public function __invoke(InvoiceWasCreated $event): void
    {
        $this->generator->generate($event->invoiceSnapshot);
    }
}
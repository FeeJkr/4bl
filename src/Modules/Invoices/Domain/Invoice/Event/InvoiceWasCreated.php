<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice\Event;

use App\Common\Domain\DomainEvent;
use App\Modules\Invoices\Domain\Invoice\InvoiceSnapshot;

final class InvoiceWasCreated implements DomainEvent
{
    public function __construct(public readonly InvoiceSnapshot $invoiceSnapshot){}
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Delete;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteInvoiceRequest extends Request
{
    public function __construct(public readonly string $invoiceId){}

    public static function fromRequest(ServerRequest $request): Request
    {
        return new self(
            $request->get('id')
        );
    }
}

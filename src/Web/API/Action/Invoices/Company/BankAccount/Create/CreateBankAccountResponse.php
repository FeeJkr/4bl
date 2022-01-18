<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\BankAccount\Create;

use App\Web\API\Action\Response;

final class CreateBankAccountResponse extends Response
{
    public static function respond(string $id): self
    {
        return new self(['id' => $id]);
    }
}

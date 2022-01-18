<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\BankAccount\GetOneById;

use App\Modules\Invoices\Application\Company\BankAccount\BankAccountDTO;
use App\Web\API\Action\Response;

final class GetOneBankAccountByIdResponse extends Response
{
    public static function respond(BankAccountDTO $bankAccount): self
    {
        return new self([
            'id' => $bankAccount->id,
            'companyId' => $bankAccount->companyId,
            'name' => $bankAccount->name,
            'bankName' => $bankAccount->bankName,
            'bankAccountNumber' => $bankAccount->bankAccountNumber,
            'currency' => $bankAccount->currency,
        ]);
    }
}

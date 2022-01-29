<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\GetAll;

use App\Modules\Invoices\Application\BankAccount\BankAccountDTO;
use App\Modules\Invoices\Application\BankAccount\BankAccountsCollection;
use App\Web\API\Action\Response;

final class GetAllBankAccountsResponse extends Response
{
    public static function respond(BankAccountsCollection $bankAccounts): self
    {
        return new self(
            array_map(static fn (BankAccountDTO $bankAccount) => [
                'id' => $bankAccount->id,
                'companyId' => $bankAccount->companyId,
                'name' => $bankAccount->name,
                'bankName' => $bankAccount->bankName,
                'bankAccountNumber' => $bankAccount->bankAccountNumber,
                'currency' => $bankAccount->currency,
            ], $bankAccounts->toArray())
        );
    }
}

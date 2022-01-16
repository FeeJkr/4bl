<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount\Delete;

use App\Common\Application\Command\Command;

final class DeleteBankAccountCommand implements Command
{
    public function __construct(
        public readonly string $id
    ){}
}

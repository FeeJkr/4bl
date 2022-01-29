<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\BankAccount;

use App\Modules\Invoices\Domain\BankAccount\BankAccount;
use App\Modules\Invoices\Domain\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Currency;
use App\Modules\Invoices\Domain\User\UserId;

final class BankAccountFactory
{
    public static function createFromRow(array $row): BankAccount
    {
        return new BankAccount(
            BankAccountId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            $row['name'],
            $row['bank_name'],
            $row['bank_account_number'],
            Currency::from($row['currency']),
        );
    }
}

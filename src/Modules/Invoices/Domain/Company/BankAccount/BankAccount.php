<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company\BankAccount;

use App\Common\Domain\Entity;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Currency;
use JetBrains\PhpStorm\Pure;

final class BankAccount extends Entity
{
    public function __construct(
        private BankAccountId $id,
        private CompanyId $companyId,
        private string $name,
        private string $bankName,
        private string $bankAccountNumber,
        private Currency $currency,
    ){}

    public function update(
        string $name,
        string $bankName,
        string $bankAccountNumber,
        Currency $currency,
    ): void {
        $this->name = $name;
        $this->bankName = $bankName;
        $this->bankAccountNumber = $bankAccountNumber;
        $this->currency = $currency;
    }

    #[Pure]
    public function snapshot(): BankAccountSnapshot
    {
        return new BankAccountSnapshot(
            $this->id->toString(),
            $this->companyId->toString(),
            $this->name,
            $this->bankName,
            $this->bankAccountNumber,
            $this->currency->value,
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use JetBrains\PhpStorm\Pure;

class CompanyPaymentInformation
{
    public function __construct(
        private CompanyPaymentInformationId $id,
        private string $paymentType,
        private int $paymentLastDay,
        private string $bank,
        private string $accountNumber,
    ){}

    public static function create(string $paymentType, int $paymentLastDay, string $bank, string $accountNumber): self
    {
        return new self(
            CompanyPaymentInformationId::generate(),
            $paymentType,
            $paymentLastDay,
            $bank,
            $accountNumber
        );
    }

    public function update(string $paymentType, int $paymentLastDay, string $bank, string $accountNumber): self
    {
        $this->paymentType = $paymentType;
        $this->paymentLastDay = $paymentLastDay;
        $this->bank = $bank;
        $this->accountNumber = $accountNumber;

        return $this;
    }

    #[Pure]
    public function getSnapshot(): CompanyPaymentInformationSnapshot
    {
        return new CompanyPaymentInformationSnapshot(
            $this->id->toString(),
            $this->paymentType,
            $this->paymentLastDay,
            $this->bank,
            $this->accountNumber,
        );
    }
}
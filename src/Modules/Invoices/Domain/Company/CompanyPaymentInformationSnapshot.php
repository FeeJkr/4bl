<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanyPaymentInformationSnapshot
{
    public function __construct(
        private string $id,
        private string $paymentType,
        private int $paymentLastDay,
        private string $bank,
        private string $accountNumber,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    public function getPaymentLastDay(): int
    {
        return $this->paymentLastDay;
    }

    public function getBank(): string
    {
        return $this->bank;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }
}
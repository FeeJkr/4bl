<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Company
{
    public function __construct(
        private CompanyId $id,
        private UserId $userId,
        private AddressId $addressId,
        private string $name,
        private string $identificationNumber,
        private bool $isVatPayer,
        private ?VatRejectionReason $vatRejectionReason,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

    public static function create(
        UserId $userId,
        AddressId $addressId,
        string $name,
        string $identificationNumber,
        bool $isVatPayer,
        ?VatRejectionReason $vatRejectionReason,
        ?string $email,
        ?string $phoneNumber,
    ): self {
        return new self(
            CompanyId::generate(),
            $userId,
            $addressId,
            $name,
            $identificationNumber,
            $isVatPayer,
            $vatRejectionReason,
            $email,
            $phoneNumber,
        );
    }

    public function update(
        string $name,
        string $identificationNumber,
        bool $isVatPayer,
        ?VatRejectionReason $vatRejectionReason,
        ?string $email,
        ?string $phoneNumber,
    ): void {
        $this->name = $name;
        $this->identificationNumber = $identificationNumber;
        $this->isVatPayer = $isVatPayer;
        $this->vatRejectionReason = $vatRejectionReason;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    #[Pure]
    public function snapshot(): CompanySnapshot
    {
        return new CompanySnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->addressId->toString(),
            $this->name,
            $this->identificationNumber,
            $this->isVatPayer,
            $this->vatRejectionReason?->value,
            $this->email,
            $this->phoneNumber,
        );
    }
}

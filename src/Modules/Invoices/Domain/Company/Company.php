<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Company
{
    public function __construct(
        private CompanyId $id,
        private UserId $userId,
        private Address $address,
        private string $name,
        private string $identificationNumber,
        private bool $isVatPayer,
        private ?VatRejectionReason $vatRejectionReason,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

    public static function create(
        UserId $userId,
        string $name,
        string $identificationNumber,
        bool $isVatPayer,
        ?VatRejectionReason $vatRejectionReason,
        ?string $email,
        ?string $phoneNumber,
        string $street,
        string $city,
        string $zipCode,
    ): self {
        return new self(
            CompanyId::generate(),
            $userId,
            new Address(
                AddressId::generate(),
                $userId,
                $name,
                $street,
                $city,
                $zipCode,
            ),
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
        string $street,
        string $city,
        string $zipCode,
    ): void {
        $this->address->update($name, $street, $city, $zipCode);

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
            $this->address->snapshot(),
            $this->name,
            $this->identificationNumber,
            $this->isVatPayer,
            $this->vatRejectionReason?->value,
            $this->email,
            $this->phoneNumber,
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanySnapshot
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $addressId,
        private ?string $paymentInformationId,
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getAddressId(): string
    {
        return $this->addressId;
    }

    public function getPaymentInformationId(): ?string
    {
        return $this->paymentInformationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentificationNumber(): string
    {
        return $this->identificationNumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
}
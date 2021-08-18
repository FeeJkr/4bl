<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

class Company
{
    public function __construct(
        private CompanyId $id,
        private UserId $userId,
        private CompanyAddress $address,
        private ?CompanyPaymentInformation $paymentInformation,
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
    ){}

    public static function create(
        UserId $userId,
        CompanyAddress $address,
        string $name,
        string $identificationNumber,
        ?string $email,
        ?string $phoneNumber,
    ): self {
        return new self(
            CompanyId::generate(),
            $userId,
            $address,
            null,
            $name,
            $identificationNumber,
            $email,
            $phoneNumber,
        );
    }

    public function update(
        string $street,
        string $zipCode,
        string $city,
        string $name,
        string $identificationNumber,
        ?string $email,
        ?string $phoneNumber,
    ): void {
        $this->address->update($street, $zipCode, $city);

        $this->name = $name;
        $this->identificationNumber = $identificationNumber;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function updatePaymentInformation(
        string $paymentType,
        int $paymentLastDate,
        string $bank,
        string $accountNumber
    ): void {
    	$this->paymentInformation = $this->paymentInformation === null
            ? CompanyPaymentInformation::create($paymentType, $paymentLastDate, $bank, $accountNumber)
            : $this->paymentInformation->update($paymentType, $paymentLastDate, $bank, $accountNumber);
    }

    public function getAddress(): CompanyAddress
    {
        return $this->address;
    }

    public function getPaymentInformation(): ?CompanyPaymentInformation
    {
        return $this->paymentInformation;
    }

    public function getSnapshot(): CompanySnapshot
    {
        return new CompanySnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->address->getSnapshot()->getId(),
            $this->paymentInformation?->getSnapshot()->getId(),
            $this->name,
            $this->identificationNumber,
            $this->email,
            $this->phoneNumber,
        );
    }
}

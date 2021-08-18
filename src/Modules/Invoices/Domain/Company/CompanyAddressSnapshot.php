<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanyAddressSnapshot
{
    public function __construct(
        private string $id,
        private string $street,
        private string $zipCode,
        private string $city,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}
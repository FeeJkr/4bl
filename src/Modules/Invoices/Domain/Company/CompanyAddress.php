<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;

final class CompanyAddress
{
    public function __construct(
        private CompanyAddressId $id,
        private string $street,
        private string $zipCode,
        private string $city,
    ){}

    public static function create(string $street, string $zipCode, string $city): self
    {
        return new self(
            CompanyAddressId::generate(),
            $street,
            $zipCode,
            $city,
        );
    }

    public function update(string $street, string $zipCode, string $city): void
    {
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
    }

    #[Pure]
    public function getSnapshot(): CompanyAddressSnapshot
    {
        return new CompanyAddressSnapshot(
            $this->id->toString(),
            $this->street,
            $this->zipCode,
            $this->city,
        );
    }
}

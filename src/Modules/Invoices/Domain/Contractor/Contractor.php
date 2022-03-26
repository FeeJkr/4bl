<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Contractor;

use App\Common\Domain\Entity;
use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Contractor extends Entity
{
    public function __construct(
        private ContractorId $id,
        private UserId $userId,
        private Address $address,
        private string $name,
        private string $identificationNumber,
    ){}

    public static function createNew(
        UserId $userId,
        string $name,
        string $identificationNumber,
        string $street,
        string $city,
        string $zipCode,
    ): self {
        return new self(
            ContractorId::generate(),
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
        );
    }

    public function update(
        string $name,
        string $identificationNumber,
        string $street,
        string $city,
        string $zipCode,
    ): void {
        $this->address->update($name, $street, $city, $zipCode);

        $this->name = $name;
        $this->identificationNumber = $identificationNumber;
    }

    #[Pure]
    public function snapshot(): ContractorSnapshot
    {
        return new ContractorSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->address->snapshot(),
            $this->name,
            $this->identificationNumber,
        );
    }
}

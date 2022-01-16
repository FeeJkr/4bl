<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Contractor;

use App\Common\Domain\Entity;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Contractor extends Entity
{
    public function __construct(
        private ContractorId $id,
        private UserId $userId,
        private AddressId $addressId,
        private string $name,
        private string $identificationNumber,
    ){}

    public function update(string $name, string $identificationNumber): void
    {
        $this->name = $name;
        $this->identificationNumber = $identificationNumber;
    }

    #[Pure]
    public function snapshot(): ContractorSnapshot
    {
        return new ContractorSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->addressId->toString(),
            $this->name,
            $this->identificationNumber,
        );
    }
}

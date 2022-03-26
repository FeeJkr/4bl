<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Address;

use App\Common\Domain\Entity;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Address extends Entity
{
    public function __construct(
        private AddressId $id,
        private UserId $userId,
        private string $name,
        private string $street,
        private string $city,
        private string $zipCode,
    ){}

    public function update(
        string $name,
        string $street,
        string $city,
        string $zipCode,
    ): void {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zipCode = $zipCode;
    }

    #[Pure]
    public function snapshot(): AddressSnapshot
    {
        return new AddressSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->name,
            $this->street,
            $this->city,
            $this->zipCode,
        );
    }
}

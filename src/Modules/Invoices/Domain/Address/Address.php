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
        private string $zipCode,
        private string $city,
    ){}

    public function update(
        string $name,
        string $street,
        string $zipCode,
        string $city,
    ): void {
        $this->name = $name;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
    }

    #[Pure]
    public function snapshot(): AddressSnapshot
    {
        return new AddressSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->name,
            $this->street,
            $this->zipCode,
            $this->city,
        );
    }
}

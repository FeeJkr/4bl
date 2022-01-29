<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Address;

use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class AddressFactory
{
    #[Pure]
    public static function createFromRow(array $row): Address
    {
        return new Address(
            AddressId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            $row['name'],
            $row['street'],
            $row['zip_code'],
            $row['city'],
        );
    }
}
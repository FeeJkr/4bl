<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\GetAll;

use App\Modules\Invoices\Application\Address\AddressDTO;
use App\Modules\Invoices\Application\Address\AddressesCollection;
use App\Web\API\Action\Response;

final class GetAllAddressesResponse extends Response
{
    public static function respond(AddressesCollection $addresses): self
    {
        return new self(
            array_map(static fn (AddressDTO $address) => [
                'id' => $address->id,
                'name' => $address->name,
                'street' => $address->street,
                'zipCode' => $address->zipCode,
                'city' => $address->city,
            ], $addresses->toArray())
        );
    }
}

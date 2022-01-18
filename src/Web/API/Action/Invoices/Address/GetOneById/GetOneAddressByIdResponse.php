<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\GetOneById;

use App\Modules\Invoices\Application\Address\AddressDTO;
use App\Web\API\Action\Response;

final class GetOneAddressByIdResponse extends Response
{
    public static function respond(AddressDTO $address): self
    {
        return new self([
            'id' => $address->id,
            'name' => $address->name,
            'street' => $address->street,
            'zipCode' => $address->zipCode,
            'city' => $address->city,
        ]);
    }
}

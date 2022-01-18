<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\Create;

use App\Web\API\Action\Response;

final class CreateAddressResponse extends Response
{
    public static function respond(string $id): self
    {
        return new self(['id' => $id]);
    }
}

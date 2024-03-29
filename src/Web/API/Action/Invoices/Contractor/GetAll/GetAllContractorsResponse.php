<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\GetAll;

use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Application\Contractor\ContractorsCollection;
use App\Web\API\Action\Response;

final class GetAllContractorsResponse extends Response
{
    public static function respond(ContractorsCollection $contractors): self
    {
        return new self(
            array_map(static fn (ContractorDTO $contractor) => [
                'id' => $contractor->id,
                'address' => [
                    'id' => $contractor->address->id,
                    'name' => $contractor->address->name,
                    'street' => $contractor->address->street,
                    'city' => $contractor->address->city,
                    'zipCode' => $contractor->address->zipCode,
                ],
                'name' => $contractor->name,
                'identificationNumber' => $contractor->identificationNumber,
            ], $contractors->items)
        );
    }
}

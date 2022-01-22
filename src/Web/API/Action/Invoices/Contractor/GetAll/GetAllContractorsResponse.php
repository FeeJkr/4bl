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
                'addressId' => $contractor->addressId,
                'name' => $contractor->name,
                'identificationNumber' => $contractor->identificationNumber,
            ], $contractors->toArray())
        );
    }
}

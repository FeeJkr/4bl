<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\GetOneById;

use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Web\API\Action\Response;

final class GetOneContractorByIdResponse extends Response
{
    public static function respond(ContractorDTO $contractor): self
    {
        return new self([
            'id' => $contractor->id,
            'addressId' => $contractor->addressId,
            'name' => $contractor->name,
            'identificationNumber' => $contractor->identificationNumber,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOneById;

use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Web\API\Action\Response;

final class GetOneCompanyByIdResponse extends Response
{
    public static function respond(CompanyDTO $company): self
    {
        return new self([
            'id' => $company->id,
            'name' => $company->name,
            'identificationNumber' => $company->identificationNumber,
            'isVatPayer' => $company->isVatPayer,
            'reason' => $company->vatRejectionReason,
            'email' => $company->email,
            'phoneNumber' => $company->phoneNumber,
        ]);
    }
}

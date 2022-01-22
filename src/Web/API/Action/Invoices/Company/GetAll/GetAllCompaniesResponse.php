<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetAll;

use App\Modules\Invoices\Application\Company\CompaniesCollection;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Web\API\Action\Response;

final class GetAllCompaniesResponse extends Response
{
    public static function respond(CompaniesCollection $companies): self
    {
        return new self(
            array_map(static fn (CompanyDTO $company) => [
                'id' => $company->id,
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer,
                'reason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
            ], $companies->items)
        );
    }
}

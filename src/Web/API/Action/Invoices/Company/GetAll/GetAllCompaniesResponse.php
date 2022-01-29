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
                'address' => [
                    'id' => $company->address->id,
                    'street' => $company->address->street,
                    'city' => $company->address->city,
                    'zipCode' => $company->address->zipCode,
                ],
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer,
                'vatRejectionReason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
            ], $companies->items)
        );
    }
}

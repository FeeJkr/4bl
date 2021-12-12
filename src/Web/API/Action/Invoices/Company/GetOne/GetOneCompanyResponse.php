<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Web\API\Action\Response;

final class GetOneCompanyResponse extends Response
{
    public static function respond(CompanyDTO $companyDTO): self
    {
        return new self([
            'id' => $companyDTO->id,
            'name' => $companyDTO->name,
            'street' => $companyDTO->street,
            'zipCode' => $companyDTO->zipCode,
            'city' => $companyDTO->city,
            'identificationNumber' => $companyDTO->identificationNumber,
            'email' => $companyDTO->email,
            'phoneNumber' => $companyDTO->phoneNumber,
            'paymentType' => $companyDTO->paymentType,
            'paymentLastDate' => $companyDTO->paymentLastDate,
            'bank' => $companyDTO->bank,
            'accountNumber' => $companyDTO->accountNumber,
        ]);
    }
}

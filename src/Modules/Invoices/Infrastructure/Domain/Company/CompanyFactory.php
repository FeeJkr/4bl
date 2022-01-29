<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\VatRejectionReason;
use App\Modules\Invoices\Domain\User\UserId;
use App\Modules\Invoices\Infrastructure\Domain\Address\AddressFactory;

final class CompanyFactory
{
    public static function createFromRow(array $row): Company
    {
        $userId = UserId::fromString($row['users_id']);

        return new Company(
            CompanyId::fromString($row['id']),
            $userId,
            AddressFactory::createFromRow([
                'id' => $row['address_id'],
                'users_id' => $row['users_id'],
                'name' => $row['address_name'],
                'street' => $row['address_street'],
                'city' => $row['address_city'],
                'zip_code' => $row['address_zip_code'],
            ]),
            $row['name'],
            $row['identification_number'],
            (bool) $row['is_vat_payer'],
            $row['vat_rejection_reason'] ? VatRejectionReason::from($row['vat_rejection_reason']) : null,
            $row['email'],
            $row['phone_number'],
        );
    }
}

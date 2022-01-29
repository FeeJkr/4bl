<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

use App\Modules\Invoices\Application\Address\AddressDTO;
use JetBrains\PhpStorm\Pure;

final class CompanyDTO
{
    public function __construct(
        public readonly string $id,
        public readonly AddressDTO $address,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $vatRejectionReason,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
    ){}

    #[Pure]
    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            AddressDTO::createFromRow([
                'id' => $storage['address_id'],
                'name' => $storage['address_name'],
                'street' => $storage['address_street'],
                'city' => $storage['address_city'],
                'zip_code' => $storage['address_zip_code'],
            ]),
            $storage['name'],
            $storage['identification_number'],
            (bool) $storage['is_vat_payer'],
            $storage['vat_rejection_reason'] !== null ? (int) $storage['vat_rejection_reason'] : null,
            $storage['email'],
            $storage['phone_number'],
        );
    }
}

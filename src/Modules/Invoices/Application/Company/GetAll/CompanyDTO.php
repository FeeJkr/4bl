<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

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
            new AddressDTO(
                $storage['address_id'],
                $storage['address_street'],
                $storage['address_city'],
                $storage['address_zip_code'],
            ),
            $storage['name'],
            $storage['identification_number'],
            (bool) $storage['is_vat_payer'],
            $storage['vat_rejection_reason'] !== null ? (int) $storage['vat_rejection_reason'] : null,
            $storage['email'],
            $storage['phone_number'],
        );
    }
}

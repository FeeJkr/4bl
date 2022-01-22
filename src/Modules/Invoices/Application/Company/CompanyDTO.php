<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

use JetBrains\PhpStorm\Pure;

final class CompanyDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $addressId,
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
            $storage['invoices_addresses_id'],
            $storage['name'],
            $storage['identification_number'],
            (bool) $storage['is_vat_payer'],
            $storage['vat_rejection_reason'] !== null ? (int) $storage['vat_rejection_reason'] : null,
            $storage['email'],
            $storage['phone_number'],
        );
    }
}

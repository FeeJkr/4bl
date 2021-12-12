<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

use JetBrains\PhpStorm\Pure;

final class CompanyDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly ?string $paymentType,
        public readonly ?int $paymentLastDate,
        public readonly ?string $bank,
        public readonly ?string $accountNumber,
    ){}

    #[Pure]
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['street'],
            $data['zip_code'],
            $data['city'],
            $data['identification_number'],
            $data['email'],
            $data['phone_number'],
            $data['payment_type'],
            (int) $data['payment_last_day'],
            $data['bank'],
            $data['account_number'],
        );
    }
}

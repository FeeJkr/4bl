<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

final class VatInformationDTO
{
    public function __construct(
        public readonly bool $isVatPayer,
        public readonly ?int $reason
    ){}
}

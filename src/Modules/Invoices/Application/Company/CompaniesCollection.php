<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

final class CompaniesCollection
{
    private array $companies;

    public function __construct(CompanyDTO ...$companies)
    {
        $this->companies = $companies;
    }

    public function add(CompanyDTO $companyDTO): void
    {
        $this->companies[] = $companyDTO;
    }

    public function toArray(): array
    {
        return $this->companies;
    }
}

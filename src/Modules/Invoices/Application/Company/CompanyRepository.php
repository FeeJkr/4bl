<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

interface CompanyRepository
{
    public function getAll(string $userId): CompaniesCollection;
    public function getById(string $id, string $userId): CompanyDTO;
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\User\UserId;

interface CompanyRepository
{
    public function fetchById(CompanyId $id, UserId $userId): ?Company;
    public function store(Company $company): void;
    public function save(Company $company): void;
    public function delete(Company $company): void;
}

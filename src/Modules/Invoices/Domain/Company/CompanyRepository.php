<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use App\Modules\Invoices\Domain\User\UserId;

interface CompanyRepository
{
    public function fetchById(CompanyId $id, UserId $userId): Company;
    public function fetchByUserId(UserId $userId): Company;

    public function store(CompanySnapshot $company): void;
    public function save(CompanySnapshot $company): void;
    public function delete(CompanyId $id, UserId $userId): void;
}

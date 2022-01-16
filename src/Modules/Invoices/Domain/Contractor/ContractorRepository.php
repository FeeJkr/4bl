<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Contractor;

use App\Modules\Invoices\Domain\User\UserId;

interface ContractorRepository
{
    public function fetchById(ContractorId $id, UserId $userId): Contractor;

    public function nextIdentity(): ContractorId;

    public function store(ContractorSnapshot $contractor): void;
    public function save(ContractorSnapshot $contractor): void;
    public function delete(ContractorId $id, UserId $userId): void;
}

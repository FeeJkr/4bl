<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor;

interface ContractorRepository
{
    public function getAll(string $userId): ContractorsCollection;
    public function getById(string $id, string $userId): ContractorDTO;
}
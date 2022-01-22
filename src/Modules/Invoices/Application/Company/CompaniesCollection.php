<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company;

final class CompaniesCollection
{
    public readonly array $items;

    public function __construct(CompanyDTO ...$items)
    {
        $this->items = $items;
    }
}

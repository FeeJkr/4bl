<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Delete;

use App\Common\Application\Command\Command;

final class DeleteCompanyCommand implements Command
{
    public function __construct(public readonly string $companyId){}
}

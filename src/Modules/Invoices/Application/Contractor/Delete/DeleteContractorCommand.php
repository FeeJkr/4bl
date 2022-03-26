<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Delete;

use App\Common\Application\Command\Command;

final class DeleteContractorCommand implements Command
{
    public function __construct(public readonly string $id){}
}

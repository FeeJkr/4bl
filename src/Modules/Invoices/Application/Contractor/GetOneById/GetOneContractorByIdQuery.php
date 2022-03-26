<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\GetOneById;

use App\Common\Application\Query\Query;

final class GetOneContractorByIdQuery implements Query
{
    public function __construct(public readonly string $id){}
}

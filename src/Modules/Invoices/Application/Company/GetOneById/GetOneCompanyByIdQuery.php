<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetOneById;

use App\Common\Application\Query\Query;

final class GetOneCompanyByIdQuery implements Query
{
    public function __construct(public readonly string $id){}
}

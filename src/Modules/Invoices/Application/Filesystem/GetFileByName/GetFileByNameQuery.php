<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\GetFileByName;

use App\Common\Application\Query\Query;

final class GetFileByNameQuery implements Query
{
    public function __construct(public readonly string $filename){}
}

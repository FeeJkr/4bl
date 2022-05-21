<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\GetFileByName;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\Filesystem\Filesystem;

final class GetFileByNameHandler implements QueryHandler
{
    public function __construct(private Filesystem $dropbox){}

    public function __invoke(GetFileByNameQuery $query): string
    {
        return $this->dropbox->getByName($query->filename);
    }
}

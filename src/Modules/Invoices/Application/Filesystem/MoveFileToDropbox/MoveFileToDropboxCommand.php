<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\MoveFileToDropbox;

use App\Common\Application\Command\Command;

final class MoveFileToDropboxCommand implements Command
{
    public function __construct(
        public readonly string $sourceFilepath,
        public readonly string $filename,
    ){}
}

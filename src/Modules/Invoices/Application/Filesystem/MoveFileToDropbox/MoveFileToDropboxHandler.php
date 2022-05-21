<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\MoveFileToDropbox;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Filesystem\Filesystem;

final class MoveFileToDropboxHandler implements CommandHandler
{
    public function __construct(private Filesystem $dropbox){}

    public function __invoke(MoveFileToDropboxCommand $command): void
    {
        $this->dropbox->upload($command->sourceFilepath, $command->filename);

        unlink($command->sourceFilepath);
    }
}

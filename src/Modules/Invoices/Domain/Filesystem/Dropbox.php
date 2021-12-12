<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Filesystem;

interface Dropbox
{
    public function upload(string $sourceFilepath, string $targetFilepath): void;
    public function getByName(string $filename): string;
}

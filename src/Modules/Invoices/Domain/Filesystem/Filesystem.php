<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Filesystem;

interface Filesystem
{
    public function upload(string $sourceFilepath, string $filename): void;
    public function getByName(string $filename): string;
}

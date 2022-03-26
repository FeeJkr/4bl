<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Web\API\Action\FileResponse;

final class GetFileByNameResponse extends FileResponse
{
    public static function respond(string $file): self
    {
        return new self($file, headers: [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetFileByNameRequest extends Request
{
    public function __construct(public readonly string $filename){}

    public static function fromRequest(ServerRequest $request): self
    {
        return new self(
            $request->get('filename')
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetOneCompanyRequest extends Request
{
    public function __construct(public readonly string $companyId){}

    public static function fromRequest(ServerRequest $request): Request
    {
        return new self(
            $request->get('id')
        );
    }
}

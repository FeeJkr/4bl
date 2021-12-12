<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Delete;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteCompanyRequest extends Request
{
    private function __construct(public readonly string $companyId){}

    public static function fromRequest(ServerRequest $request): self
    {
        $companyId = $request->get('id');

        Assert::lazy()
            ->that($companyId, 'companyId')->notEmpty()->uuid()
            ->verifyNow();

        return new self(
            $companyId,
        );
    }
}

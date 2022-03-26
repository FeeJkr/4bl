<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Delete;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteCompanyRequest extends Request
{
    private const ID = 'id';

    public function __construct(public readonly string $id){}

    public static function fromRequest(ServerRequest $request): self
    {
        $id = $request->get(self::ID);

        Assert::lazy()
            ->that($id, self::ID)->uuid()->notEmpty()
            ->verifyNow();

        return new self($id);
    }
}

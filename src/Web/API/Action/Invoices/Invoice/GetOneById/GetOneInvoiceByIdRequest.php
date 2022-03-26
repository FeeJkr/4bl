<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetOneById;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetOneInvoiceByIdRequest extends Request
{
    private const ID = 'id';

    public function __construct(public readonly string $id){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $id = $request->get(self::ID);

        Assert::lazy()
            ->that($id, self::ID)->uuid()->notEmpty()
            ->verifyNow();

        return new self($id);
    }
}

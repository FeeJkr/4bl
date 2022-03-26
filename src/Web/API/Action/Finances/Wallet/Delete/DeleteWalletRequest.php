<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Delete;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteWalletRequest extends Request
{
    private const ID = 'id';

    public function __construct(public readonly string $id){}

    public static function fromRequest(ServerRequest $request): self
    {
        $id = $request->get(self::ID);

        Assert::lazy()
            ->that('id')->notNull($id)->uuid()
            ->verifyNow();

        return new self($id);
    }
}

<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetById;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetWalletByIdRequest extends Request
{
    private const ID = 'id';

    public function __construct(private string $id){}

    public static function fromRequest(ServerRequest $request): self
    {
        $id = $request->get(self::ID);

        Assert::lazy()
            ->that($id, self::ID)->notEmpty()->uuid()
            ->verifyNow();

        return new self($id);
    }

    public function getId(): string
    {
        return $this->id;
    }
}
<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Edit;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class EditWalletRequest extends Request
{
    private const ID = 'id';
    private const NAME = 'name';
    private const START_BALANCE = 'startBalance';
    private const CURRENCY = 'currency';

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $startBalance,
        public readonly string $currency,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();
        $id = $request->get('id');
        $name = $requestData[self::NAME];
        $startBalance = $requestData[self::START_BALANCE];
        $currency = $requestData[self::CURRENCY];

        Assert::lazy()
            ->that($id, self::ID)->notEmpty()->uuid()
            ->that($name, self::NAME)->notEmpty()->string()->maxLength(254)
            ->that($startBalance, self::START_BALANCE)->notEmpty()->integer()
            ->that($currency, self::CURRENCY)->notEmpty()->string()->maxLength(20)
            ->verifyNow();

        return new self(
            $id,
            $name,
            $startBalance,
            $currency
        );
    }
}

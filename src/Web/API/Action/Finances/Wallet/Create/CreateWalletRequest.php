<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateWalletRequest extends Request
{
    private const NAME = 'name';
    private const START_BALANCE = 'startBalance';
    private const CURRENCY = 'currency';

    public function __construct(
        private string $name,
        private int $startBalance,
        private string $currency,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();

        $name = $requestData[self::NAME];
        $startBalance = (int) $requestData[self::START_BALANCE];
        $currency = $requestData[self::CURRENCY];

        Assert::lazy()
            ->that($name, self::NAME)->notEmpty()->maxLength(254)
            ->that($startBalance, self::START_BALANCE)->notEmpty()->integer()
            ->that($currency, self::CURRENCY)->notEmpty()->maxLength(254)
            ->verifyNow();

        return new self(
            $name,
            $startBalance,
            $currency,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
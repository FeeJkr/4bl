<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Currency;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class CreateWalletHandler implements CommandHandler
{
    public function __construct(private WalletRepository $repository, private UserContext $userContext){}

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = Wallet::create(
            $this->userContext->getUserId(),
            $command->name,
            new Money($command->startBalance, Currency::from($command->currency))
        );

        $this->repository->store($wallet);
    }
}

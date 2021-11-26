<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Edit;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Currency;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class EditWalletHandler implements CommandHandler
{
    public function __construct(
        private WalletRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(EditWalletCommand $command): void
    {
        $wallet = $this->repository->getById(WalletId::fromString($command->getId()), $this->userContext->getUserId());

        $wallet->update(
            $command->getName(),
            new Money($command->getStartBalance(), new Currency($command->getCurrency()))
        );

        $this->repository->save($wallet);
    }
}
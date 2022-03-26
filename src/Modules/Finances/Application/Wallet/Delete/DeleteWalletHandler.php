<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class DeleteWalletHandler implements CommandHandler
{
    public function __construct(
        private WalletRepository $repository,
        private UserContext $userContext
    ){}

    public function __invoke(DeleteWalletCommand $command): void
    {
        $this->repository->delete(
            WalletId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }
}

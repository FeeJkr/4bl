<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class DeleteAddressHandler implements CommandHandler
{
    public function __construct(private AddressRepository $repository, private UserContext $userContext){}

    public function __invoke(DeleteAddressCommand $command): void
    {
        $this->repository->delete(
            AddressId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }
}

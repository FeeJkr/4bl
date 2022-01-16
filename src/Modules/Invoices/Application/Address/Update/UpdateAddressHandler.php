<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class UpdateAddressHandler implements CommandHandler
{
    public function __construct(private AddressRepository $repository, private UserContext $userContext){}

    public function __invoke(UpdateAddressCommand $command): void
    {
        $address = $this->repository->fetchById(
            AddressId::fromString($command->id),
            $this->userContext->getUserId(),
        );

        $address->update(
            $command->name,
            $command->street,
            $command->zipCode,
            $command->city,
        );

        $this->repository->save($address->snapshot());
    }
}

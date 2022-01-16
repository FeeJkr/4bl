<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateAddressHandler implements CommandHandler
{
    public function __construct(
        private AddressRepository $addressRepository,
        private UserContext $userContext,
    ){}

    public function __invoke(CreateAddressCommand $command): string
    {
        $address = new Address(
            $this->addressRepository->nextIdentity(),
            $this->userContext->getUserId(),
            $command->name,
            $command->street,
            $command->zipCode,
            $command->city,
        );

        $this->addressRepository->store($address->snapshot());

        return $address->snapshot()->id;
    }
}

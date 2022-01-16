<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Address\AddressDTO;
use App\Modules\Invoices\Application\Address\AddressesCollection;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllAddressesHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllAddressesQuery $query): AddressesCollection
    {
        $addresses = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'name',
                'street',
                'zip_code',
                'city',
            )
            ->from('invoices_addresses')
            ->where('users_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->fetchAllAssociative();

        return new AddressesCollection(
            ...array_map(static fn(array $address) => AddressDTO::fromStorage($address), $addresses)
        );
    }
}

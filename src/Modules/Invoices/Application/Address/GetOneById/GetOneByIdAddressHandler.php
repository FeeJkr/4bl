<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Address\AddressDTO;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetOneByIdAddressHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetOneByIdAddressQuery $query): AddressDTO
    {
        $address = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'name',
                'street',
                'zip_code',
                'city',
            )
            ->from('invoices_addresses')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $query->id,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        return AddressDTO::fromStorage($address);
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Application\Contractor\ContractorsCollection;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllContractorsHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllContractorsQuery $query): ContractorsCollection
    {
        $contractors = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'invoices_addresses_id',
                'name',
                'identification_number',
            )
            ->from('invoices_contractors')
            ->where('users_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->fetchAllAssociative();

        return new ContractorsCollection(
            ...array_map(static fn(array $storage) => ContractorDTO::fromStorage($storage), $contractors)
        );
    }
}

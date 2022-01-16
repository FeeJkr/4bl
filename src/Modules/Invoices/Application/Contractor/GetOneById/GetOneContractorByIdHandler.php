<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetOneContractorByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetOneContractorByIdQuery $query): ContractorDTO
    {
        $contractor = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'invoices_addresses_id',
                'name',
                'identification_number',
            )
            ->from('invoices_contractors')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $query->id,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        return ContractorDTO::fromStorage($contractor);
    }
}

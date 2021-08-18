<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Finances\Application\Wallet\WalletDTO;
use App\Modules\Finances\Application\Wallet\WalletDTOCollection;
use App\Modules\Finances\Domain\User\UserContext;
use Doctrine\DBAL\Connection;

final class GetAllWalletsHandler implements QueryHandler
{
    public function __construct(
        private Connection $connection,
        private UserContext $userContext,
    ){}

    public function __invoke(GetAllWalletsQuery $query): WalletDTOCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select([
                'id',
                'user_id',
                'name',
                'start_balance',
                'currency',
            ])
            ->from('wallets')
            ->where('user_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->execute()
            ->fetchAllAssociative();

        $collection = new WalletDTOCollection;

        foreach ($rows as $row) {
            $collection->add(WalletDTO::createFromRow($row));
        }

        return $collection;
    }
}
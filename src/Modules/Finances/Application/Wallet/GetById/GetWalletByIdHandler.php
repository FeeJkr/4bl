<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Finances\Application\Wallet\WalletDTO;
use App\Modules\Finances\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetWalletByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetWalletByIdQuery $query): WalletDTO
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'user_id',
                'name',
                'start_balance',
                'currency',
            )
            ->from('wallets')
            ->where('user_id = :userId')
            ->andWhere('id = :id')
            ->setParameters([
                'id' => $query->id,
                'user_id' => $this->userContext->getUserId(),
            ])
            ->executeQuery()
            ->fetchAssociative();

        return WalletDTO::createFromRow($row);
    }
}

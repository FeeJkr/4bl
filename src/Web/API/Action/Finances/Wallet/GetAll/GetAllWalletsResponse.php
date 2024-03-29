<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetAll;

use App\Modules\Finances\Application\Wallet\WalletDTO;
use App\Modules\Finances\Application\Wallet\WalletDTOCollection;
use App\Web\API\Action\Response;

final class GetAllWalletsResponse extends Response
{
    public static function respond(WalletDTOCollection $collection): self
    {
        return new self(
            array_map(static fn(WalletDTO $wallet) => [
                'id' => $wallet->id,
                'name' => $wallet->name,
                'startBalance' => $wallet->startBalance,
                'currency' => $wallet->currency,
            ], $collection->toArray())
        );
    }
}

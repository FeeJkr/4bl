<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetById;

use App\Modules\Finances\Application\Wallet\WalletDTO;
use App\Web\API\Action\Response;

final class GetWalletByIdResponse extends Response
{
    public static function respond(WalletDTO $wallet): self
    {
        return new self([
            'id' => $wallet->id,
            'name' => $wallet->name,
            'startBalance' => $wallet->startBalance,
            'currency' => $wallet->currency,
        ]);
    }
}

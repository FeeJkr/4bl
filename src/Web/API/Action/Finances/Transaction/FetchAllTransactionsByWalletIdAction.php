<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\FetchAllByWallet\FetchAllTransactionsByWalletQuery;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchAllTransactionsByWalletIdAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllTransactionsByWalletQuery(
            WalletId::fromInt((int) $request->get('wallet_id')),
            UserId::fromInt($request->get('user_id'))
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult()
            ->toArray();

        return new JsonResponse($result);
    }
}

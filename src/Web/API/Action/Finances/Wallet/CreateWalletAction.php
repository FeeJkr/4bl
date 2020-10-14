<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateWalletAction implements AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {


        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}

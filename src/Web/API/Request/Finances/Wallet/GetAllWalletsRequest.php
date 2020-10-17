<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Wallet;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllWalletsRequest extends Request
{
    private string $userToken;

    public function __construct(string $userToken)
    {
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            $userToken
        );
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use App\Common\Domain\Entity;
use App\Modules\Accounts\Domain\User\Event\UserWasRegistered;
use JetBrains\PhpStorm\Pure;

final class User extends Entity
{
    public function __construct(
        private UserId $id,
        private string $email,
        private string $username,
        private string $password,
        private string $firstName,
        private string $lastName,
        private Status $status,
    ){}

    public static function register(
        string $email,
        string $username,
        string $password,
        string $firstName,
        string $lastName,
    ): self {
        $user = new self(
            UserId::generate(),
            $email,
            $username,
            $password,
            $firstName,
            $lastName,
            Status::EMAIL_VERIFICATION(),
        );

        $user->publishDomainEvent(
            new UserWasRegistered($email, $username, $firstName, $lastName)
        );

        return $user;
    }

    #[Pure]
    public function getSnapshot(): UserSnapshot
    {
        return new UserSnapshot(
            $this->id->toString(),
            $this->email,
            $this->username,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->status->getValue(),
        );
    }
}

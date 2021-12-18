<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User;

use App\Modules\Accounts\Domain\DomainException;
use Exception;
use JetBrains\PhpStorm\Pure;

final class ApplicationException extends Exception
{
    #[Pure]
    public static function fromDomainException(DomainException $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}

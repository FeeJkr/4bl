<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

use Exception;
use JetBrains\PhpStorm\Pure;

final class CompanyException extends Exception
{
    #[Pure]
    public static function notFoundById(string $id): self
    {
        return new self(sprintf('Company with id "%s" not found.', $id));
    }
}
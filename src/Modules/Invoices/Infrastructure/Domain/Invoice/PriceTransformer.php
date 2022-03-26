<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use PHPHtmlParser\Dom;
use Throwable;

final class PriceTransformer
{
    private const API_URL = 'https://slownie.pl/%s';
    private const API_DATA_SELECTOR = '#dataWord';

    public function transformToText(float $price): string
    {
        try {
            $url = sprintf(self::API_URL, number_format($price, 2, ',', ''));

            return (new Dom())
                ->loadFromUrl($url)
                ->find(self::API_DATA_SELECTOR)[0]
                ->innerText;
        } catch (Throwable) {
            return '';
        }
    }
}

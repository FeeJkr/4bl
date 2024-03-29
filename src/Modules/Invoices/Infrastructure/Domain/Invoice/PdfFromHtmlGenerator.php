<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Modules\Invoices\Application\Filesystem\MoveFileToDropbox\MoveFileToDropboxCommand;
use App\Modules\Invoices\Domain\Invoice\InvoiceSnapshot;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Messenger\MessageBusInterface;

final class PdfFromHtmlGenerator
{
    public function __construct(
        private Client $httpClient,
        private MessageBusInterface $bus,
        private TwigHtmlGenerator $htmlGenerator,
        private string $host,
    ){}

    /**
     * @throws GuzzleException
     */
    public function generate(InvoiceSnapshot $snapshot): void
    {
        $filepath = sprintf('generated-files/%s.pdf', $snapshot->id);

        $this->httpClient->post(sprintf('%s/v1/invoice/generate', rtrim($this->host, '/')), [
            'json' => [
                'parameters' => $this->htmlGenerator->prepareParameters($snapshot),
                'country' => 'pl',
            ],
            'sink' => $filepath,
        ]);

        $this->bus->dispatch(
            new MoveFileToDropboxCommand(
                $filepath,
                $snapshot->id,
            )
        );
    }
}

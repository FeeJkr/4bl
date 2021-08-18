<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Filesystem;

use App\Modules\Invoices\Domain\Filesystem\Dropbox;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Throwable;

class DropboxApiIntegration implements Dropbox
{
    private const DROPBOX_UPLOAD_URL = 'https://content.dropboxapi.com/2/files/upload';
    private const DROPBOX_DOWNLOAD_URL = 'https://content.dropboxapi.com/2/files/download';

    public function __construct(private Client $httpClient, private string $dropboxAuthorizationToken){}

    /**
     * @throws Exception
     */
    public function upload(string $sourceFilepath, string $targetFilepath): void
    {
        try {
            $this->httpClient->post(self::DROPBOX_UPLOAD_URL, [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->dropboxAuthorizationToken),
                    'Content-Type' => 'application/octet-stream',
                    'Dropbox-API-Arg' => json_encode([
                        'path' => $targetFilepath,
                        'mode' => 'overwrite'
                    ], JSON_THROW_ON_ERROR),
                ],
                'body' => fopen($sourceFilepath, 'rb'),
            ]);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getByName(string $filename): string
    {
        $response = $this->httpClient->post(self::DROPBOX_DOWNLOAD_URL, [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->dropboxAuthorizationToken),
                'Dropbox-API-Arg' => json_encode([
                    'path' => "/autogenerated/{$filename}.pdf",
                ], JSON_THROW_ON_ERROR),
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
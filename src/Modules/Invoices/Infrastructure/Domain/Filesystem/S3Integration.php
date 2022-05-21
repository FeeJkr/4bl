<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Filesystem;

use App\Modules\Invoices\Domain\Filesystem\Filesystem;
use App\Modules\Invoices\Domain\User\UserContext;
use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;

final class S3Integration implements Filesystem
{
    public function __construct(
        private readonly string $s3Endpoint,
        private readonly string $key,
        private readonly string $secret,
        private readonly string $bucket,
        private readonly UserContext $userContext,
    ) {}

    public function upload(string $sourceFilepath, string $filename): void
    {
        $this->getClient()->upload(
            $this->bucket,
            $this->generateKey($filename),
            fopen($sourceFilepath, 'rb')
        );
    }

    public function getByName(string $filename): string
    {
        $command = $this->getClient()->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $this->generateKey($filename),
        ]);

        $response = $this->getClient()->createPresignedRequest($command, '+10 minutes');

        return file_get_contents((string)$response->getUri());
    }

    private function getClient(): S3ClientInterface
    {
        return new S3Client([
            'version' => 'latest',
            'region' => 'eu',
            'endpoint' => $this->s3Endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ]);
    }

    private function generateKey(string $filename): string
    {
        return sprintf('invoices/%s/%s', $this->userContext->getUserId()->toString(), $filename);
    }
}

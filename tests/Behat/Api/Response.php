<?php

declare(strict_types=1);

namespace App\Behat\Api;

use Symfony\Component\HttpFoundation;

final readonly class Response
{
    public static function ofSymfonyResponse(HttpFoundation\Response $response): self
    {
        return new self(
            $response->getStatusCode(),
            json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR),
        );
    }

    private function __construct(public int $status, public array $content)
    {
    }

    public function isSuccessful(): bool
    {
        return $this->status < 400;
    }
}

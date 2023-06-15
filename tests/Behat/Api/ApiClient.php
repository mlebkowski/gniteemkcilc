<?php

declare(strict_types=1);

namespace App\Behat\Api;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

final class ApiClient
{
    private ?Response $lastResponse = null;

    public function __construct(private readonly KernelInterface $kernel)
    {
    }

    public function get(string $path): Response
    {
        return $this->execute($this->createRequest('GET', $path));
    }

    public function post(string $path, mixed $payload): Response
    {
        return $this->execute($this->createRequest('POST', $path, $payload));
    }

    public function put(string $path, mixed $payload): Response
    {
        return $this->execute($this->createRequest('PUT', $path, $payload));
    }

    public function getLastResponse(): Response
    {
        return $this->lastResponse;
    }

    private function execute(Request $request): Response
    {
        $this->lastResponse = Response::ofSymfonyResponse($this->kernel->handle($request));
        return $this->lastResponse;
    }

    private function createRequest(string $method, string $path, mixed $payload = null): Request
    {
        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ];

        return Request::create($path, $method, server: $headers, content: json_encode($payload));
    }
}

<?php

declare(strict_types=1);

namespace App\Behat;

use App\Behat\Api\ApiClient;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Webmozart\Assert\Assert;

final class MeetingContext implements Context
{
    private string|null $meetingId = null;

    public function __construct(private ApiClient $apiClient)
    {
    }

    /**
     * @Given I create a meeting
     */
    public function i create a meeting(): void
    {
        $response = $this->apiClient->post('/meeting', ['name' => 'Eric Cantona']);
        $this->meetingId = $response->content['id'];
    }

    /**
     * @When I fetch meeting details via API
     */
    public function i fetch meeting details via API(): void
    {
        $response = $this->apiClient->get("/meeting/{$this->meetingId}");
        assert($response->isSuccessful());
    }

    /**
     * @Then It has :status status
     */
    public function it has status(string $status): void
    {
        $actual = $this->apiClient->getLastResponse()->content['status'];
        Assert::same($actual, $status);
    }
}

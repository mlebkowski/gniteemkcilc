<?php

declare(strict_types=1);

namespace App\Behat;

use App\Behat\Api\ApiClient;
use App\Common\Clock\Clock;
use Behat\Behat\Context\Context;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class MeetingContext implements Context
{
    private string|null $meetingId = null;

    public function __construct(private ApiClient $apiClient, private Clock $clock)
    {
    }

    /**
     * @Given I create a meeting
     */
    public function i create a meeting(): void
    {
        $this->i create a meeting for(
            $this->clock->now()->modify('+1 hour')->format(DATE_ATOM),
        );
    }

    /**
     * @Given I create a meeting for :when
     */
    public function i create a meeting for(string $when): void
    {
        $date = new DateTimeImmutable($when);
        $response = $this->apiClient->post(
            '/meeting',
            [
                'name' => 'Eric Cantona',
                'startDate' => $date->format(DATE_ATOM),
            ],
        );
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

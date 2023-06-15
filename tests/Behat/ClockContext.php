<?php

declare(strict_types=1);

namespace App\Behat;

use App\Common\Clock\AdjustableClock;
use Behat\Behat\Context\Context;
use DateTime;

final readonly class ClockContext implements Context
{
    public function __construct(private AdjustableClock $clock)
    {
    }

    /** @Given now is :date */
    public function now is(string $date): void
    {
        $base = ('+' === $date[0] || '-' === $date[0]) ? $this->clock->now() : new DateTime();
        $this->clock->adjust($base->modify($date));
    }
}

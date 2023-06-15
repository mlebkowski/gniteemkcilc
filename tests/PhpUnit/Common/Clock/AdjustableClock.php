<?php

declare(strict_types=1);

namespace App\Common\Clock;

use DateTimeImmutable;
use DateTimeInterface;

final class AdjustableClock implements Clock
{
    private Seconds $difference;

    public function __construct()
    {
        $this->clear();
    }

    public function adjust(DateTimeInterface $now): void
    {
        $this->difference = Seconds::of(
            $now->getTimestamp() - (new DateTimeImmutable())->getTimestamp(),
        );
    }

    public function clear(): void
    {
        $this->difference = Seconds::none();
    }

    public function now(): DateTimeImmutable
    {
        return (new DateTimeImmutable())->modify(
            sprintf(
                '%d seconds',
                $this->difference->value,
            ),
        );
    }
}

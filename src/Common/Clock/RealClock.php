<?php

declare(strict_types=1);

namespace App\Common\Clock;

use DateTimeImmutable;

final class RealClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}

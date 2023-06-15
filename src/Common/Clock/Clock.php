<?php

declare(strict_types=1);

namespace App\Common\Clock;

use DateTimeImmutable;

interface Clock
{
    public function now(): DateTimeImmutable;
}

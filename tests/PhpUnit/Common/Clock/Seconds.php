<?php

declare(strict_types=1);

namespace App\Common\Clock;

final readonly class Seconds
{
    public static function of(int $value): self
    {
        return new self($value);
    }

    public static function none(): self
    {
        return new self(0);
    }

    private function __construct(public int $value)
    {
    }
}

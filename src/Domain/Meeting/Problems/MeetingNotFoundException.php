<?php

declare(strict_types=1);

namespace App\Domain\Meeting\Problems;

use Exception;

final class MeetingNotFoundException extends Exception
{
    public static function ofId(string $id): self
    {
        return new self(sprintf('Meeting {%s} not found', $id));
    }
}

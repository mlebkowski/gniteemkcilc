<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

use DateTimeImmutable;

final class MeetingMother
{
    public static function some(): Meeting
    {
        return new Meeting(
            '',
            new DateTimeImmutable(),
        );
    }
}
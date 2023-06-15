<?php

declare(strict_types=1);

namespace App\Domain\Meeting\Problems;

use App\Domain\Meeting\Meeting;
use Exception;

final class MeetingFullException extends Exception
{
    public static function ofMeeting(Meeting $meeting): self
    {
        return new self(
            sprintf(
                'Meeting %s is already at its capacity and cannot accept more participants',
                $meeting->name,
            ),
        );
    }
}

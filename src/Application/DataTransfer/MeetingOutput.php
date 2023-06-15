<?php

declare(strict_types=1);

namespace App\Application\DataTransfer;

use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingStatus;

final readonly class MeetingOutput
{
    public static function ofMeeting(Meeting $meeting): self
    {
        return new self($meeting->id, $meeting->getStatus());
    }

    private function __construct(public string $id, public MeetingStatus $status)
    {
    }
}

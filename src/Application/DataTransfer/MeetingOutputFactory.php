<?php

declare(strict_types=1);

namespace App\Application\DataTransfer;

use App\Common\Clock\Clock;
use App\Domain\Meeting\Meeting;

final readonly class MeetingOutputFactory
{
    public function __construct(private Clock $clock)
    {
    }

    public function ofMeeting(Meeting $meeting): MeetingOutput
    {
        return MeetingOutput::ofMeeting($meeting, $this->clock);
    }
}

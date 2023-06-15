<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\Meeting\Problems\MeetingNotFoundException;

interface MeetingRepository
{
    /**
     * @throws MeetingNotFoundException
     */
    public function get(string $meetingId): Meeting;

    public function save(Meeting $meeting): void;
}

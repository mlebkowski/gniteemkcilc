<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

enum MeetingStatus: string
{
    case OpenToRegistration = "open to registration";
    case Full = "full";
    case InSession = "in session";
    case Done = "done";
}

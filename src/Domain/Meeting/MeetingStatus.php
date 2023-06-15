<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

enum MeetingStatus: string
{
// "open to registration" - if meeting has fewer than 5 participants and didn't start yet
// "full" - if there are 5 participants, but it didn't start yet
// "in session" - if it has started but didn't finish
    case OpenToRegistration = "open to registration";
    case Full = "full";
    case InSession = "in session";
    case Done = "done";
}

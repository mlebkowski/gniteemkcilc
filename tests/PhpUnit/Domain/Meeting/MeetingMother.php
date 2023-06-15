<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\User\UserMother;
use DateTimeImmutable;

final class MeetingMother
{
    public static function some(): Meeting
    {
        return new Meeting(
            '',
            new DateTimeImmutable('+10 minutes'),
        );
    }

    public static function withMaxParticipants(): Meeting
    {
        $meeting = self::some();
        $meeting->addAParticipant(UserMother::some());
        $meeting->addAParticipant(UserMother::some());
        $meeting->addAParticipant(UserMother::some());
        $meeting->addAParticipant(UserMother::some());
        $meeting->addAParticipant(UserMother::some());
        return $meeting;
    }

    public static function withPastEndDate(): Meeting
    {
        return new Meeting('', new DateTimeImmutable('-2 hours'));
    }

    public static function inSession(): Meeting
    {
        return new Meeting('', new DateTimeImmutable('-30 minutes'));
    }
}

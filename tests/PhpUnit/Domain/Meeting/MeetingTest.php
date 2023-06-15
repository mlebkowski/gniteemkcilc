<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Common\Clock\RealClock;
use App\Domain\Meeting\Problems\MeetingFullException;
use App\Domain\User\UserMother;
use PHPUnit\Framework\TestCase;

class MeetingTest extends TestCase
{
    public function test it allows only a maximum number of participants(): void
    {
        $sut = MeetingMother::withMaxParticipants();

        self::expectException(MeetingFullException::class);
        $sut->addAParticipant(UserMother::some());
    }

    public function test it is done after end passed(): void
    {
        $sut = MeetingMother::withPastEndDate();
        $actual = $sut->getStatus(new RealClock());
        self::assertSame(MeetingStatus::Done, $actual);
    }

    public function test it is in session if the end date has not passed yet(): void
    {
        $sut = MeetingMother::inSession();
        $actual = $sut->getStatus(new RealClock());
        self::assertSame(MeetingStatus::InSession, $actual);
    }

    public function test it reports it is full(): void
    {
        $sut = MeetingMother::withMaxParticipants();
        $actual = $sut->getStatus(new RealClock());
        self::assertSame(MeetingStatus::Full, $actual);
    }

    public function test it is open to registration(): void
    {
        $sut = MeetingMother::some();
        $actual = $sut->getStatus(new RealClock());
        self::assertSame(MeetingStatus::OpenToRegistration, $actual);
    }
}

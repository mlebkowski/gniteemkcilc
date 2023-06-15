<?php

declare(strict_types=1);

namespace App\Domain\Meeting;

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
}

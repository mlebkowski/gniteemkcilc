<?php
declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\Meeting\Problems\MeetingFullException;
use App\Domain\User\User;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Ulid;

final class Meeting
{
    private const ParticipantLimit = 5;
    public readonly string $id;
    public readonly string $name;
    public readonly DateTimeImmutable $startTime;
    public readonly DateTimeImmutable $endTime;
    /** @var Collection<int,User>  */
    private Collection $participants;

    public function __construct(string $name, DateTimeImmutable $startTime)
    {
        $this->id = Ulid::generate();
        $this->name = $name;
        $this->startTime = $startTime;
        $this->endTime = $startTime->add(DateInterval::createFromDateString('1 hour'));
        $this->participants = new ArrayCollection();
    }

    /**
     * @throws MeetingFullException
     */
    public function addAParticipant(User $participant): void
    {
        if ($this->isFull()) {
            throw Problems\MeetingFullException::ofMeeting($this);
        }

        $this->participants->add($participant);
    }

    public function getStatus(): MeetingStatus
    {
        return match (true) {
            $this->endTime < new DateTimeImmutable() => MeetingStatus::Done,
            $this->startTime < new DateTimeImmutable() => MeetingStatus::InSession,
            $this->isFull() => MeetingStatus::Full,
            default => MeetingStatus::OpenToRegistration,
        };
    }

    private function isFull(): bool
    {
        return $this->participants->count() >= self::ParticipantLimit;
    }
}

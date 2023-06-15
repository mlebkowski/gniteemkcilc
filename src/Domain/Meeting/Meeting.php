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

final readonly class Meeting
{
    private const ParticipantLimit = 5;
    public string $id;
    public string $name;
    public DateTimeImmutable $startTime;
    public DateTimeImmutable $endTime;
    /** @var Collection<int,User>  */
    public Collection $participants;

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
        if ($this->participants->count() >= self::ParticipantLimit) {
            throw Problems\MeetingFullException::ofMeeting($this);
        }

        $this->participants->add($participant);
    }
}

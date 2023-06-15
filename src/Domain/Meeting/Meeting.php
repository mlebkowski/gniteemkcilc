<?php
declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\User\User;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final readonly class Meeting
{
    public string $id;

    public string $name;

    public DateTimeImmutable $startTime;

    public DateTimeImmutable $endTime;

    /** @var Collection<int,User>  */
    public Collection $participants;

    public function __construct(string $name, DateTimeImmutable $startTime)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->startTime = $startTime;
        $this->endTime = $startTime->add(DateInterval::createFromDateString('1 hour'));
        $this->participants = new ArrayCollection();
    }

    public function addAParticipant(User $participant): void
    {
        $this->participants->add($participant);
    }
}

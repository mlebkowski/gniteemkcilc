<?php
declare(strict_types=1);

namespace App\Infrastructure\Meeting;

use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingRepository;
use App\Domain\Meeting\Problems\MeetingNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineMeetingRepository implements MeetingRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function get(string $meetingId): Meeting
    {
        return $this->em->getRepository(Meeting::class)->find($meetingId)
            ?? throw MeetingNotFoundException::ofId($meetingId);
    }

    public function save(Meeting $meeting): void
    {
        $this->em->persist($meeting);
        $this->em->flush();
    }
}

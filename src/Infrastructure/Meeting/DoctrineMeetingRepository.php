<?php
declare(strict_types=1);

namespace App\Infrastructure\Meeting;

use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

final class DoctrineMeetingRepository implements MeetingRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(string $meetingId): Meeting
    {
        return $this->entityManager->getRepository(Meeting::class)->find($meetingId)
            ?? throw new RuntimeException('Oops!');
    }
}

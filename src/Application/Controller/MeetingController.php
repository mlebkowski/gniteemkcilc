<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\DataTransfer\CreateMeetingInput;
use App\Application\DataTransfer\MeetingOutput;
use App\Application\DataTransfer\MeetingOutputFactory;
use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingRepository;
use App\Domain\Meeting\Problems\MeetingNotFoundException;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final readonly class MeetingController
{
    public function __construct(
        private MeetingRepository $meetings,
        private MeetingOutputFactory $factory,
    ) {
    }

    #[Route('/meeting/{id}')]
    public function get(string $id): MeetingOutput
    {
        try {
            $meeting = $this->meetings->get($id);
        } catch (MeetingNotFoundException) {
            throw new NotFoundHttpException();
        }

        return $this->factory->ofMeeting($meeting);
    }

    #[Route('/meeting', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateMeetingInput $input): MeetingOutput
    {
        $meeting = new Meeting($input->name, $input->startDate);
        $this->meetings->save($meeting);

        return $this->factory->ofMeeting($meeting);
    }
}

<?php
declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Meeting\MeetingRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final readonly class DefaultController
{
    public function __construct(private MeetingRepository $meetingRepository)
    {
    }

    #[Route('/meetings/{id}', name: 'meeting')]
    public function meeting(string $meetingId): Response
    {
        $meeting = $this->meetingRepository->get($meetingId);
        return new JsonResponse($meeting);
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return new Response('<h1>Hello</h1>');
    }
}

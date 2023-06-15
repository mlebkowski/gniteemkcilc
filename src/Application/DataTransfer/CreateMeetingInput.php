<?php

declare(strict_types=1);

namespace App\Application\DataTransfer;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateMeetingInput
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(new DateTimeImmutable())]
    public DateTimeImmutable $startDate;

}

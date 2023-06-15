<?php
declare(strict_types=1);

namespace App\Domain\User;

use Symfony\Component\Uid\Ulid;

final readonly class User
{
    public string $id;

    public string $name;

    public function __construct(string $name)
    {
        $this->id = Ulid::generate();
        $this->name = $name;
    }
}

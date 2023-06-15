<?php
declare(strict_types=1);

namespace App\Domain\User;

final readonly class User
{
    public string $id;

    public string $name;

    public function __construct(string $name)
    {
        $this->id = uniqid();
        $this->name = $name;
    }
}

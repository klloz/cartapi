<?php

namespace App\Domain\Product;

use Ramsey\Uuid\UuidInterface;

class Currency
{
    private int $id;
    private UuidInterface $uuid;
    private string $name;

    public function __construct(UuidInterface $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

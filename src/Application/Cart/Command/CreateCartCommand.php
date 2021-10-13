<?php

namespace App\Application\Cart\Command;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

final class CreateCartCommand
{
    /**
     * @Assert\NotBlank()
     */
    public UuidInterface $uuid;

    public function __construct()
    {
        $this->uuid = UuidV4::uuid4();
    }
}

<?php

namespace App\Application\Product\Command;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

final class CreateProductCommand
{
    /**
     * @Assert\NotBlank()
     */
    public ?UuidInterface $uuid;

    /**
     * @Assert\NotBlank()
     */
    public ?string $title;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    public ?float $price;

    /**
     * @Assert\NotBlank()
     */
    public ?int $currencyId;

    public function __construct(?string $title = null, ?float $price = null, ?int $currencyId = null)
    {
        $this->uuid = UuidV4::uuid4();
        $this->title = $title;
        $this->price = $price;
        $this->currencyId = $currencyId;
    }
}

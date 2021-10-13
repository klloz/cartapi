<?php

namespace App\Application\Product\Command;

final class EditProductCommand
{
    /**
     * @Assert\NotBlank()
     */
    public ?int $id;

    /**
     * @Assert\NotBlank()
     */
    public ?string $title;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    public ?float $price;

    public function __construct(?int $id = null, ?string $title = null, ?float $price = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }
}

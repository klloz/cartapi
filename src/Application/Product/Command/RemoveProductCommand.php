<?php

namespace App\Application\Product\Command;

final class RemoveProductCommand
{
    /**
     * @Assert\NotBlank()
     */
    public ?int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }
}

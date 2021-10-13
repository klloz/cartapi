<?php

namespace App\Shared\Application\Query;

final class PagedQueryParameters
{
    const DEFAULT_PAGE = 1;
    const DEFAULT_PAGE_COUNT = 3;

    /**
     * @Assert\GreaterThan(0)
     */
    public ?int $page;

    /**
     * @Assert\GreaterThan(0)
     */
    public ?int $count;

    public function __construct(?int $page = null, ?int $count = null)
    {
        $this->page = $page;
        $this->count = $count;
    }

    public function getPage(): int
    {
        return $this->page ?? self::DEFAULT_PAGE;
    }

    public function getCount(): int
    {
        return $this->count ?? self::DEFAULT_PAGE_COUNT;
    }

    public function getOffset()
    {
        return ($this->getPage() - 1) * $this->getCount();
    }
}

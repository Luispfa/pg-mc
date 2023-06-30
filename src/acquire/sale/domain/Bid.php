<?php

declare(strict_types=1);

namespace App\acquire\sale\domain;

final class Bid
{
    /** var Bid[] */
    private array $bids = [];

    public function __construct(public readonly string $buyer)
    {
    }

    public function addBid(int ...$amount): void
    {
        $this->bids = $amount;
    }

    public function bids(): array
    {
        return $this->bids;
    }

    public function maxBid(): ?int
    {
        return $this->bids ? max($this->bids) : null;
    }
}

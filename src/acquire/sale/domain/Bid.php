<?php

declare(strict_types=1);

namespace App\acquire\sale\domain;

final class Bid
{
    /** var Bid[] */
    private array $bids = [];

    private function __construct(public readonly string $buyer)
    {
    }

    public static function create(string $buyer, ?int ...$bids): self
    {
        $bid = new self($buyer);
        if ($bids) {
            $bid->addBid(...$bids);
        }

        return $bid;
    }

    public function addBid(int ...$bids): void
    {
        $this->bids = $bids;
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

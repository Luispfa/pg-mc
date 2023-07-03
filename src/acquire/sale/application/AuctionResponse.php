<?php

declare(strict_types=1);

namespace App\acquire\sale\application;

readonly final  class AuctionResponse
{
    public function __construct(public string|null $buyer, public int $winningPrice)
    {
    }
}

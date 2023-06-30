<?php

declare(strict_types=1);

namespace App\acquire\sale\domain;

interface BidRepository
{
    public function getBids(): array;
}

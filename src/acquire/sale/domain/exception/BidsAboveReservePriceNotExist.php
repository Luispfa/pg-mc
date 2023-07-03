<?php

declare(strict_types=1);

namespace App\acquire\sale\domain\exception;

use RuntimeException;

final class BidsAboveReservePriceNotExist extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('bids price above reserve price don\'t exist');
    }
}

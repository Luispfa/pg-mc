<?php

declare(strict_types=1);

namespace App\acquire\sale\domain\service;

use App\acquire\sale\domain\Bid;
use App\acquire\sale\domain\exception\BidsAboveReservePriceNotExist;

final class BidsAboveReservePrice
{
    /**
     * Filters and sorts an array of Bid objects to obtain only the bids that exceed the reserve price.
     *
     * @param array<Bid> $bids An array of Bid objects representing bids.
     * @param int $reservePrice The minimum reserve price that bids must exceed.
     * @return array<Bid> An array of Bid objects that exceed the reserve price, sorted from lowest to highest.
     * @throws BidsAboveReservePriceNotExist If there are no bids that exceed the reserve price.
     */
    public function __invoke(array $bids, int $reservePrice): array
    {
        $validBids = array_filter($bids, fn (Bid $bid) => $bid->maxBid() >= $reservePrice);
        if (empty($validBids)) {
            throw new BidsAboveReservePriceNotExist();
        }
        usort($validBids, fn (Bid $bid1, Bid $bid2) => $bid1->maxBid() <=> $bid2->maxBid());

        return $validBids;
    }
}

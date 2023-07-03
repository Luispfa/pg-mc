<?php

declare(strict_types=1);

namespace App\acquire\sale\domain\service;

use App\acquire\sale\domain\Bid;

final class BidWinner
{
    /**
     * Calculates the winning bid and returns a Bid object representing the winner.
     *
     * @param array<Bid> $bids An array of Bid objects representing the bids.
     * @param int $reservePrice The reserve price for the auction.
     * @return Bid The Bid object representing the winning bid.
     */
    public function __invoke(array $bids, int $reservePrice): Bid
    {
        $lastTwoValidBids = array_slice($bids, -2);

        $beforeWinnerBid = current($lastTwoValidBids);
        $winnerBid = end($lastTwoValidBids);

        $winner = $winnerBid->buyer;
        $winningPrice = $beforeWinnerBid !== $winnerBid ? $beforeWinnerBid->maxBid() : $reservePrice;

        return Bid::create($winner, $winningPrice);
    }
}

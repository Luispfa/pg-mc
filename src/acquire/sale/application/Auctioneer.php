<?php

declare(strict_types=1);

namespace App\acquire\sale\application;

use App\acquire\sale\domain\BidRepository;
use App\acquire\sale\domain\service\BidsAboveReservePrice;
use App\acquire\sale\domain\service\BidWinner;
use App\acquire\sale\domain\exception\BidsNotExist;

final class Auctioneer
{
    public function __construct(private BidRepository $bidRepository)
    {
    }

    /**
     * @throws BidsNotExist If there are no bids available for the auction.
     */
    public function __invoke(int $reservePrice): AuctionResponse
    {
        $bids = $this->bidRepository->getBids();
        if (empty($bids)) {
            throw new BidsNotExist();
        }

        $validBids = (new BidsAboveReservePrice())($bids, $reservePrice);
        $bidwinner = (new BidWinner())($validBids, $reservePrice);

        return new AuctionResponse($bidwinner->buyer, current($bidwinner->bids()));
    }
}

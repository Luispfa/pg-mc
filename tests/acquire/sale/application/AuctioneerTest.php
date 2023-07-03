<?php

declare(strict_types=1);

namespace App\Tests\acquire\sale\application;

use App\acquire\sale\application\Auctioneer;
use App\acquire\sale\application\AuctionResponse;
use App\acquire\sale\domain\Bid;
use App\acquire\sale\domain\BidRepository;
use App\acquire\sale\domain\exception\BidsAboveReservePriceNotExist;
use App\acquire\sale\domain\exception\BidsNotExist;
use PHPUnit\Framework\TestCase;

class AuctioneerTest extends TestCase
{
    /**
     * @dataProvider BidsProvider
     */
    public function testAuctioneer(
        array $bids,
        int $reservePrice,
        AuctionResponse $expectedResult
    ): void {
        $bidRepository = $this->createMock(BidRepository::class);
        $bidRepository->expects(self::once())
            ->method('getBids')
            ->willReturn($bids);

        $auctioneer = new Auctioneer($bidRepository);
        $actualResult = $auctioneer($reservePrice);

        self::assertEquals($expectedResult, $actualResult);
    }

    public static function BidsProvider(): array
    {
        $bidA = Bid::create('A', 110, 130);
        $bidB = Bid::create('B');
        $bidC = Bid::create('C', 125);
        $bidD = Bid::create('D', 105, 115, 90);
        $bidE = Bid::create('E', 132, 135, 140);

        return [
            "Case 01" => [
                [$bidA, $bidB, $bidC, $bidD, $bidE],
                100,
                new AuctionResponse('E', 130)
            ],
            "Case 02" => [
                [$bidB, $bidC, $bidD],
                120,
                new AuctionResponse('C', 120)
            ],
            "Case 03" => [
                [$bidC, $bidD, $bidA],
                120,
                new AuctionResponse('A', 125)
            ],
        ];
    }

    public function testBidsNotExistException(): void
    {
        $this->expectException(BidsNotExist::class);
        $bidRepository = $this->createMock(BidRepository::class);
        $bidRepository->expects(self::once())
            ->method('getBids')
            ->willReturn([]);

        $auctioneer = new Auctioneer($bidRepository);
        $actualResult = $auctioneer(150);
    }

    /**
     * @dataProvider BidsExceptionProvider
     */
    public function testBidsAboveReservePriceNotExistException(
        array $bids,
        int $reservePrice,
    ): void {
        $this->expectException(BidsAboveReservePriceNotExist::class);
        $bidRepository = $this->createMock(BidRepository::class);
        $bidRepository->expects(self::once())
            ->method('getBids')
            ->willReturn($bids);

        $auctioneer = new Auctioneer($bidRepository);
        $actualResult = $auctioneer($reservePrice);
    }

    public static function BidsExceptionProvider(): array
    {
        $bidA = Bid::create('A', 110, 130);
        $bidB = Bid::create('B');
        $bidC = Bid::create('C', 125);
        $bidD = Bid::create('D', 105, 115, 90);
        $bidE = Bid::create('E', 132, 135, 140);

        return [
            "Case 01" => [
                [$bidA, $bidB, $bidC, $bidD, $bidE],
                150
            ],

        ];
    }
}

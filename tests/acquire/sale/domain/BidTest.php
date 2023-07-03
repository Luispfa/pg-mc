<?php

declare(strict_types=1);

namespace App\Tests\acquire\sale\domain;

use App\acquire\sale\domain\Bid;
use PHPUnit\Framework\TestCase;

class BidTest extends TestCase
{
    public function testAddBid()
    {
        $bid = Bid::create('A', 100, 150);

        $expectedBids = [100, 150];
        $actualBids = $bid->bids();

        self::assertIsArray($actualBids);
        self::assertSame($expectedBids, $actualBids);
    }

    public function testNotAddBid()
    {
        $bid = Bid::create('B');

        $expectedBids = [];
        $actualBids = $bid->bids();

        self::assertIsArray($actualBids);
        self::assertSame($expectedBids, $actualBids);
    }

    public function testMaxBid(): void
    {
        $bid = Bid::create('C', 100, 150, 200);

        $expectedMaxBid = 200;
        $actualMaxBid = $bid->maxBid();

        self::assertSame($expectedMaxBid, $actualMaxBid);
    }

    public function testMaxEmptyBid(): void
    {
        $bid = Bid::create('C');

        $actualMaxBid = $bid->maxBid();

        self::assertNull($actualMaxBid);
    }
}

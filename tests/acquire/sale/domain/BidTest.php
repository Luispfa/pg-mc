<?php

declare(strict_types=1);

namespace App\Tests\acquire\sale\domain;

use App\acquire\sale\domain\Bid;
use PHPUnit\Framework\TestCase;

final class BidTest extends TestCase
{
    public function testAddBid()
    {
        $bid = new Bid('A');
        $bid->addBid(100, 150);

        $expectedBids = [100, 150];
        $actualBids = $bid->bids();

        self::assertIsArray($actualBids);
        self::assertSame($expectedBids, $actualBids);
    }

    public function testNotAddBid()
    {
        $bid = new Bid('B');

        $expectedBids = [];
        $actualBids = $bid->bids();

        self::assertIsArray($actualBids);
        self::assertSame($expectedBids, $actualBids);
    }

    public function testMaxBid(): void
    {
        $bid = new Bid('C');
        $bid->addBid(100, 150, 200);

        $expectedMaxBid = 200;
        $actualMaxBid = $bid->maxBid();

        self::assertSame($expectedMaxBid, $actualMaxBid);
    }

    public function testMaxEmptyBid(): void
    {
        $bid = new Bid('C');

        $actualMaxBid = $bid->maxBid();

        self::assertNull($actualMaxBid);
    }
}

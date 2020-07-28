<?php

namespace Tests\Antonowano\QiwiTopup;

use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;
use PHPUnit\Framework\TestCase;

class QiwiTopupTest extends TestCase
{
    private const TERMINAL_ID = 123;
    private const PASSWORD = 'qwerty';

    public function testGetBalance()
    {
        $qiwi = new QiwiTopup();
        $requestFactory = new RequestFactory(self::TERMINAL_ID, self::PASSWORD);
        $request = $requestFactory->createForGetBalance();
        $response = $qiwi->sendRequest($request);

        $this->assertSame($response->getResultCode(), 0);
        $this->assertFalse($response->getFatalError());
        $this->assertIsArray($response->getBalances());
    }
}

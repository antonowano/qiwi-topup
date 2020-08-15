<?php

namespace Tests\Antonowano\QiwiTopup;

use Antonowano\QiwiTopup\Constant\Currencies;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;
use PHPUnit\Framework\TestCase;

class QiwiTopupTest extends TestCase
{
    private const TERMINAL_ID = 123;
    private const PASSWORD = 'qwerty';
    private const CARD = '4111111111111111';

    /** @var QiwiTopup */
    private $qiwi;

    /** @var RequestFactory */
    private $requestFactory;

    protected function setUp(): void
    {
        $this->qiwi = new QiwiTopup();
        $this->requestFactory = new RequestFactory(self::TERMINAL_ID, self::PASSWORD);
    }

    public function testGetBalance()
    {
        $request = $this->requestFactory->createForGetBalance();
        $response = $this->qiwi->sendRequest($request);

        $this->assertSame(0, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertIsArray($response->getBalances());
    }

    public function testPayment()
    {
        $transactionNumber = rand(10000000000000, 10000000009999);
        $request = $this->requestFactory->createForPayToCard();
        $request
            ->setTransactionNumber($transactionNumber)
            ->setFromCcy(Currencies::RUB)
            ->setToAccountNumber(self::CARD)
            ->setToCcy(Currencies::RUB)
            ->setToAmount(1)
        ;
        $response = $this->qiwi->sendRequest($request);
        $payment = $response->getPayment();

        $this->assertSame(0, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertNotNull($payment);
        $this->assertSame($transactionNumber, $payment->getTransactionNumber());

        return $transactionNumber;
    }

    /**
     * @depends testPayment
     */
    public function testGetStatus(int $transactionNumber)
    {
        $request = $this->requestFactory->createForGetStatus();
        $request->setTransactionNumber($transactionNumber);
        $response = $this->qiwi->sendRequest($request);
        $payment = $response->getPayment();

        $this->assertSame(0, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertNotNull($payment);
        $this->assertSame($transactionNumber, $payment->getTransactionNumber());
    }
}

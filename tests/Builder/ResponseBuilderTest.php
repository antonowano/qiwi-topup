<?php

namespace Tests\Antonowano\QiwiTopup\Builder;

use Antonowano\QiwiTopup\Builder\ResponseBuilder;
use Antonowano\QiwiTopup\Constant\Currencies;
use Antonowano\QiwiTopup\Constant\ErrorCodes;
use Antonowano\QiwiTopup\Constant\ServiceIds;
use PHPUnit\Framework\TestCase;

class ResponseBuilderTest extends TestCase
{
    /**
     * @var ResponseBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        $this->builder = new ResponseBuilder();
    }

    public function testResponseBalance()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <result-code fatal="false">0</result-code>
                <balances>
                    <balance code="428">100.00</balance>
                    <balance code="643">200.26</balance>
                    <balance code="840">300.00</balance>
                </balances>
            </response>
        ');
        $this->assertNull($response->getPayment());
        $this->assertSame(ErrorCodes::NO_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertSame([
            Currencies::LVL => 100.0,
            Currencies::RUB => 200.26,
            Currencies::USD => 300.0
        ], $response->getBalances());
    }

    public function testResponsePayCard()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <payment status="60" txn_id="6060" transaction-number="12345678" result-code="0" final-status="true" 
                         fatal-error="false" txn-date="02.03.2011 14:35:46">
                    <from>
                        <amount>15.00</amount>
                        <ccy>643</ccy>
                    </from>
                    <to>
                        <service-id>34020</service-id>
                        <amount>15.00</amount>
                        <ccy>643</ccy>
                        <account-number>4111********1123</account-number>
                    </to>
                </payment>
                <balances>
                    <balance code="428">0.00</balance>
                    <balance code="643">200</balance>
                    <balance code="840">12.20</balance>
                </balances>
            </response>
        ');
        $payment = $response->getPayment();
        $this->assertSame(60, $payment->getStatus());
        $this->assertSame(6060, $payment->getTransactionId());
        $this->assertSame(12345678, $payment->getTransactionNumber());
        $this->assertSame('2011-03-02 14:35:46', $payment->getTransactionDate()->format('Y-m-d H:i:s'));
        $this->assertSame(15.0, $payment->getFromAmount());
        $this->assertSame(Currencies::RUB, $payment->getFromCcy());
        $this->assertSame(null, $payment->getFromServiceId());
        $this->assertSame('4111********1123', $payment->getToAccountNumber());
        $this->assertSame(15.0, $payment->getToAmount());
        $this->assertSame(Currencies::RUB, $payment->getToCcy());
        $this->assertSame(ServiceIds::CARD, $payment->getToServiceId());
        $this->assertTrue($payment->getFinalStatus());
        $this->assertSame(ErrorCodes::NO_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertSame([
            Currencies::LVL => 0.0,
            Currencies::RUB => 200.0,
            Currencies::USD => 12.20
        ], $response->getBalances());
    }

    public function testResponsePayQIWI()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <payment status="60" txn_id="60601" transaction-number="123456789" result-code="0" 
                         final-status="true" fatal-error="false" txn-date="02.03.2018 14:35:46">
                    <from>
                        <amount>150.00</amount>
                        <ccy>643</ccy>
                    </from>
                    <to>
                        <service-id>99</service-id>
                        <amount>150.00</amount>
                        <ccy>643</ccy>
                        <account-number>79181234568</account-number>
                    </to>
                </payment>
                <balances>
                    <balance code="978">0.00</balance>
                    <balance code="643">200</balance>
                    <balance code="840">12.20</balance>
                </balances>
            </response>
        ');
        $payment = $response->getPayment();
        $this->assertSame(60, $payment->getStatus());
        $this->assertSame(60601, $payment->getTransactionId());
        $this->assertSame(123456789, $payment->getTransactionNumber());
        $this->assertSame('2018-03-02 14:35:46', $payment->getTransactionDate()->format('Y-m-d H:i:s'));
        $this->assertSame(150.0, $payment->getFromAmount());
        $this->assertSame(Currencies::RUB, $payment->getFromCcy());
        $this->assertSame(null, $payment->getFromServiceId());
        $this->assertSame('79181234568', $payment->getToAccountNumber());
        $this->assertSame(Currencies::RUB, $payment->getToCcy());
        $this->assertSame(150.0, $payment->getToAmount());
        $this->assertSame(ServiceIds::QIWI, $payment->getToServiceId());
        $this->assertTrue($payment->getFinalStatus());
        $this->assertSame(ErrorCodes::NO_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertSame([
            Currencies::EUR => 0.0,
            Currencies::RUB => 200.0,
            Currencies::USD => 12.20
        ], $response->getBalances());
    }

    public function testResponseStatus()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <result-code fatal="false">0</result-code>
                <payment status="60" transaction-number="12345678" txn_id="759640439" result-сode="0" final-status="true" 
                         fatal-error="false" txn-date="12.03.2012 14:24:38" />
                <balances>
                    <balance code="643">90.79</balance>
                    <balance code="840">0.00</balance>
                </balances>
            </response>
        ');
        $payment = $response->getPayment();
        $this->assertSame(60, $payment->getStatus());
        $this->assertSame(759640439, $payment->getTransactionId());
        $this->assertSame(12345678, $payment->getTransactionNumber());
        $this->assertSame('2012-03-12 14:24:38', $payment->getTransactionDate()->format('Y-m-d H:i:s'));
        $this->assertSame(null, $payment->getFromAmount());
        $this->assertSame(null, $payment->getFromCcy());
        $this->assertSame(null, $payment->getFromServiceId());
        $this->assertSame(null, $payment->getToAccountNumber());
        $this->assertSame(null, $payment->getToCcy());
        $this->assertSame(null, $payment->getToAmount());
        $this->assertSame(null, $payment->getToServiceId());
        $this->assertTrue($payment->getFinalStatus());
        $this->assertSame(ErrorCodes::NO_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertSame([
            Currencies::RUB => 90.79,
            Currencies::USD => 0.0
        ], $response->getBalances());
    }

    public function testResponseCheckDepositPossible()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <result-code fatal="false">0</result-code>
                <exist>1</exist>
                <deposit-possible>1</deposit-possible>
            </response>
        ');
        $this->assertSame(ErrorCodes::NO_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
        $this->assertTrue($response->getExist());
        $this->assertTrue($response->getDepositPossible());
        $this->assertNull($response->getBalances());
        $this->assertNull($response->getPayment());
        $this->assertNull($response->getMessage());
    }

    public function testErrorResponseCheckDepositPossible()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <result-code fatal="true" message="Недостаточный статус идентификации кошелька для проведения платежа" 
                    msg="Недостаточный статус идентификации кошелька для проведения платежа">204</result-code>
                <exist>1</exist>
                <deposit-possible>0</deposit-possible>
            </response>
        ');
        $this->assertSame(ErrorCodes::BAD_IDENT, $response->getResultCode());
        $this->assertTrue($response->getFatalError());
        $this->assertTrue($response->getExist());
        $this->assertFalse($response->getDepositPossible());
        $this->assertNull($response->getBalances());
        $this->assertNull($response->getPayment());
        $this->assertSame(
            'Недостаточный статус идентификации кошелька для проведения платежа',
            $response->getMessage()
        );
    }

    public function testErrorResponse()
    {
        $response = $this->builder->build('<?xml version="1.0" encoding="utf-8"?>
            <response>
              <result-code fatal="false">300</result-code>
            </response>
        ');
        $this->assertSame(ErrorCodes::UNKNOWN_ERROR, $response->getResultCode());
        $this->assertFalse($response->getFatalError());
    }
}

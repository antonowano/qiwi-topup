<?php

namespace Tests\Antonowano\QiwiTopup\Builder;

use Antonowano\QiwiTopup\Builder\XMLBuilder;
use Antonowano\QiwiTopup\Constant\Currencies;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use PHPUnit\Framework\TestCase;

class XMLBuilderTest extends TestCase
{
    /**
     * @var RequestFactory
     */
    private $factory;

    /**
     * @var XMLBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        $this->factory = new RequestFactory('123', 'password');
        $this->builder = new XMLBuilder();
    }

    public function testGetBalance()
    {
        $request = $this->factory->createForGetBalance();
        $this->assertXmlStringEqualsXmlString(
            $this->builder->build($request),
            '<?xml version="1.0" encoding="utf-8"?>
            <request>
                <request-type>ping</request-type>
                <terminal-id>123</terminal-id>
                <extra name="password">password</extra>
            </request>
        ');
    }

    public function testPayCard()
    {
        $request = $this->factory->createForPayToCard();
        $request
            ->setTransactionNumber(12345678)
            ->setFromCcy(Currencies::RUB)
            ->setToAmount(1115)
            ->setToCcy(Currencies::RUB)
            ->setToAccountNumber('4265111122334411')
        ;
        $this->assertXmlStringEqualsXmlString('<?xml version="1.0" encoding="utf-8"?>
            <request>
                <request-type>pay</request-type>
                <terminal-id>123</terminal-id>
                <extra name="password">password</extra>
                <auth>
                    <payment>
                        <transaction-number>12345678</transaction-number>
                        <from>
                            <ccy>643</ccy>
                        </from>
                        <to>
                            <amount>1115</amount>
                            <ccy>643</ccy>
                            <service-id>34020</service-id>
                            <account-number>4265111122334411</account-number>
                        </to>
                    </payment>
                </auth>
            </request>',
            $this->builder->build($request)
        );
    }

    public function testPayQIWI()
    {
        $request = $this->factory->createForPayToQiwi();
        $request
            ->setIncomeWireTransfer(1)
            ->setToAmount(15)
            ->setToCcy(Currencies::RUB)
            ->setFromCcy(Currencies::USD)
            ->setTransactionNumber(321456)
            ->setToAccountNumber('79181234567')
        ;
        $this->assertXmlStringEqualsXmlString('<?xml version="1.0" encoding="utf-8"?>
            <request>
                <request-type>pay</request-type>
                <terminal-id>123</terminal-id>
                <extra name="password">password</extra>
                <extra name="income_wire_transfer">1</extra>
                <auth>
                    <payment>
                        <transaction-number>321456</transaction-number>
                        <from>
                            <ccy>840</ccy>
                        </from>
                        <to>
                            <amount>15</amount>
                            <ccy>643</ccy>
                            <service-id>99</service-id>
                            <account-number>79181234567</account-number>
                        </to>
                    </payment>
                </auth>
            </request>',
            $this->builder->build($request)
        );
    }

    public function testStatus()
    {
        $request = $this->factory->createForGetStatus();
        $request
            ->setTransactionNumber(12345678)
            ->setToAccountNumber('79181234567')
        ;
        $this->assertXmlStringEqualsXmlString('<?xml version="1.0" encoding="utf-8"?>
            <request>
                <request-type>pay</request-type>
                <terminal-id>123</terminal-id>
                <extra name="password">password</extra>
                <status>
                    <payment>
                        <transaction-number>12345678</transaction-number>
                        <to>
                             <account-number>79181234567</account-number>
                        </to>
                    </payment>
                </status>
            </request>',
            $this->builder->build($request)
        );
    }

    public function testCheckDepositPossible()
    {
        $request = $this->factory->createForCheckDepositPossible();
        $request
            ->setPhone('79031234567')
            ->setIncomeWireTransfer(1)
        ;
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="utf-8"?>
            <request>
              <request-type>check-deposit-possible</request-type>
              <terminal-id>123</terminal-id>
              <extra name="password">password</extra>
              <extra name="phone">79031234567</extra>
              <extra name="income_wire_transfer">1</extra>
            </request>',
            $this->builder->build($request)
        );
    }
}

<?php

namespace Antonowano\QiwiTopup\Factory;

use Antonowano\QiwiTopup\Constant\GroupTags;
use Antonowano\QiwiTopup\Constant\RequestTypes;
use Antonowano\QiwiTopup\Constant\ServiceIds;
use Antonowano\QiwiTopup\Request;

class RequestFactory
{
    private $terminalId;
    private $password;

    public function __construct(int $terminalId, string $password)
    {
        $this->terminalId = $terminalId;
        $this->password = $password;
    }

    public function createForGetBalance(): Request
    {
        $request = new Request();
        $request
            ->setRequestType(RequestTypes::PING)
            ->setTerminalId($this->terminalId)
            ->setPassword($this->password)
        ;
        return $request;
    }

    public function createForPayToCard(): Request
    {
        $request = new Request();
        $request
            ->setRequestType(RequestTypes::PAY)
            ->setTerminalId($this->terminalId)
            ->setPassword($this->password)
            ->setGroupTag(GroupTags::AUTH)
            ->setToServiceId(ServiceIds::CARD)
        ;
        return $request;
    }

    public function createForPayToQiwi(): Request
    {
        $request = new Request();
        $request
            ->setRequestType(RequestTypes::PAY)
            ->setTerminalId($this->terminalId)
            ->setPassword($this->password)
            ->setGroupTag(GroupTags::AUTH)
            ->setToServiceId(ServiceIds::QIWI)
        ;
        return $request;
    }

    public function createForGetStatus(): Request
    {
        $request = new Request();
        $request
            ->setRequestType(RequestTypes::PAY)
            ->setTerminalId($this->terminalId)
            ->setPassword($this->password)
            ->setGroupTag(GroupTags::STATUS)
        ;
        return $request;
    }

    public function createForCheckDepositPossible(): Request
    {
        $request = new Request();
        $request
            ->setRequestType(RequestTypes::CHECK_DEPOSIT_POSSIBLE)
            ->setTerminalId($this->terminalId)
            ->setPassword($this->password)
        ;
        return $request;
    }
}

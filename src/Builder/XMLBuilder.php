<?php

namespace Antonowano\QiwiTopup\Builder;

use Antonowano\QiwiTopup\Request;

class XMLBuilder
{
    public function build(Request $request)
    {
        $xml = new \SimpleXMLElement('<request/>');
        $xml->addChild('request-type', $request->getRequestType());
        $xml->addChild('terminal-id', $request->getTerminalId());
        $password = $xml->addChild('extra', $request->getPassword());
        $password->addAttribute('name', 'password');

        if ($request->getPhone()) {
            $phone = $xml->addChild('extra', $request->getPhone());
            $phone->addAttribute('name', 'phone');
        }

        if ($request->getIncomeWireTransfer() !== null) { // maybe zero
            $incomeWireTransfer = $xml->addChild('extra', $request->getIncomeWireTransfer());
            $incomeWireTransfer->addAttribute('name', 'income_wire_transfer');
        }

        if ($request->getGroupTag()) {
            $payment = $xml->addChild($request->getGroupTag())->addChild('payment');
            $payment->addChild('transaction-number', $request->getTransactionNumber());

            if ($request->hasTagFrom()) {
                $from = $payment->addChild('from');

                if ($request->getFromCcy()) {
                    $from->addChild('ccy', $request->getFromCcy());
                }

                if ($request->getFromServiceId()) {
                    $from->addChild('service-id', $request->getFromServiceId());
                }
            }

            if ($request->hasTagTo()) {
                $to = $payment->addChild('to');

                if ($request->getToAmount()) {
                    $to->addChild('amount', $request->getToAmount());
                }

                if ($request->getToCcy()) {
                    $to->addChild('ccy', $request->getToCcy());
                }

                if ($request->getToServiceId()) {
                    $to->addChild('service-id', $request->getToServiceId());
                }

                if ($request->getToAccountNumber()) {
                    $to->addChild('account-number', $request->getToAccountNumber());
                }
            }
        }

        return $xml->asXML();
    }
}

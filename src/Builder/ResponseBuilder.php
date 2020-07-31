<?php

namespace Antonowano\QiwiTopup\Builder;

use Antonowano\QiwiTopup\Convert\XmlConvert;
use Antonowano\QiwiTopup\PaymentResponse;
use Antonowano\QiwiTopup\Response;

class ResponseBuilder
{
    public function build(string $xmlString): Response
    {
        $response = new Response();
        $cv = new XmlConvert();
        $xml = new \SimpleXMLElement($xmlString);
        $payment = $xml->{'payment'};
        $resultCode = $xml->{'result-code'};

        if ($payment) {
            $paymentResponse = new PaymentResponse();
            $paymentResponse
                ->setStatus($cv->int($payment['status']))
                ->setTransactionId($cv->int($payment['txn_id']))
                ->setTransactionNumber($cv->int($payment['transaction-number']))
                ->setTransactionDate($cv->datetime($payment['txn-date'], 'd.m.Y H:i:s'))
                ->setFromAmount($cv->float($payment->{'from'}->{'amount'}))
                ->setFromCcy($cv->int($payment->{'from'}->{'ccy'}))
                ->setFromServiceId($cv->int($payment->{'from'}->{'service-id'}))
                ->setToAmount($cv->float($payment->{'to'}->{'amount'}))
                ->setToCcy($cv->int($payment->{'to'}->{'ccy'}))
                ->setToServiceId($cv->int($payment->{'to'}->{'service-id'}))
                ->setToAccountNumber($cv->string($payment->{'to'}->{'account-number'}))
                ->setFinalStatus($cv->bool($payment['final-status']))
            ;
            $response
                ->setResultCode($cv->int($payment['result-code']))
                ->setFatalError($cv->bool($payment['fatal-error']))
                ->setPayment($paymentResponse)
            ;
        }

        if ($resultCode) {
            $response
                ->setResultCode($cv->int($resultCode))
                ->setFatalError($cv->bool($resultCode['fatal']))
                ->setMessage($cv->string($resultCode['message']))
            ;
        }

        $response
            ->setExist($cv->bool($xml->{'exist'}))
            ->setDepositPossible($cv->bool($xml->{'deposit-possible'}))
            ->setBalances($cv->balances($xml->{'balances'}))
        ;

        return $response;
    }
}

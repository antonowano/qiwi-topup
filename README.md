Example
===
Install
---
```text
composer require antonowano/qiwi-topup
```
Get balance
---
```php
use Antonowano\QiwiTopup\Constant\ErrorCodes;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;

$qiwi = new QiwiTopup();
$requestFactory = new RequestFactory(123, 'password');
$request = $requestFactory->createForGetBalance();
$response = $qiwi->sendRequest($request);

if ($response->getResultCode() == ErrorCodes::NO_ERROR) {
    var_dump($response->getBalances());
}
```

Pay to card
---
```php
use Antonowano\QiwiTopup\Constant\Currencies;
use Antonowano\QiwiTopup\Constant\PaymentStatuses;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;

$qiwi = new QiwiTopup();
$requestFactory = new RequestFactory(123, 'password');
$request = $requestFactory->createForPayToCard();
$request
    ->setTransactionNumber(12345678)
    ->setFromCcy(Currencies::RUB)
    ->setToAmount(1115)
    ->setToCcy(Currencies::RUB)
    ->setToAccountNumber('4265111122334411')
;
$response = $qiwi->sendRequest($request);
$payment = $response->getPayment();

if ($payment->getStatus() == PaymentStatuses::EXECUTED) {
    echo $payment->getTransactionNumber();
}
```

Pay to QIWI
---
```php
use Antonowano\QiwiTopup\Constant\Currencies;
use Antonowano\QiwiTopup\Constant\PaymentStatuses;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;

$qiwi = new QiwiTopup();
$requestFactory = new RequestFactory(123, 'password');
$request = $requestFactory->createForPayToQiwi();
$request
    ->setIncomeWireTransfer(1)
    ->setToAmount(15)
    ->setToCcy(Currencies::RUB)
    ->setFromCcy(Currencies::USD)
    ->setTransactionNumber(321456)
    ->setToAccountNumber('79181234567')
;
$response = $qiwi->sendRequest($request);
$payment = $response->getPayment();

if ($payment->getStatus() == PaymentStatuses::EXECUTED) {
    echo $payment->getTransactionNumber();
}
```

Get status
---
```php
use Antonowano\QiwiTopup\Constant\PaymentStatuses;
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;

$qiwi = new QiwiTopup();
$requestFactory = new RequestFactory(123, 'password');
$request = $requestFactory->createForGetStatus();
$request
    ->setTransactionNumber(12345678)
    ->setToAccountNumber('79181234567')
;
$response = $qiwi->sendRequest($request);
$payment = $response->getPayment();

if ($payment->getStatus() == PaymentStatuses::EXECUTED) {
    echo $payment->getTransactionNumber();
}
```

Check deposit possible
---
```php
use Antonowano\QiwiTopup\Factory\RequestFactory;
use Antonowano\QiwiTopup\QiwiTopup;

$qiwi = new QiwiTopup();
$requestFactory = new RequestFactory(123, 'password');
$request = $requestFactory->createForCheckDepositPossible();
$request
    ->setPhone('79031234567')
    ->setIncomeWireTransfer(1)
;
$response = $qiwi->sendRequest($request);
$exist = $response->getExist();
$possible = $response->getDepositPossible();
```

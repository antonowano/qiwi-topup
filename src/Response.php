<?php

namespace Antonowano\QiwiTopup;

class Response
{
    /** @var PaymentResponse|null */
    private $payment;

    /** @var int|null */
    private $resultCode;

    /** @var bool|null */
    private $fatalError;

    /** @var array|null */
    private $balances;

    /** @var bool|null */
    private $exist;

    /** @var bool|null */
    private $depositPossible;

    /** @var string */
    private $message;

    public function getPayment(): ?PaymentResponse
    {
        return $this->payment;
    }

    public function setPayment(?PaymentResponse $payment): self
    {
        $this->payment = $payment;
        return $this;
    }

    public function getResultCode(): ?int
    {
        return $this->resultCode;
    }

    public function setResultCode(?int $resultCode): self
    {
        $this->resultCode = $resultCode;
        return $this;
    }

    public function getFatalError(): ?bool
    {
        return $this->fatalError;
    }

    public function setFatalError(?bool $fatalError): self
    {
        $this->fatalError = $fatalError;
        return $this;
    }

    public function getBalances(): ?array
    {
        return $this->balances;
    }

    public function setBalances(?array $balances): self
    {
        $this->balances = $balances;
        return $this;
    }

    public function getExist(): ?bool
    {
        return $this->exist;
    }

    public function setExist(?bool $exist): Response
    {
        $this->exist = $exist;
        return $this;
    }

    public function getDepositPossible(): ?bool
    {
        return $this->depositPossible;
    }

    public function setDepositPossible(?bool $depositPossible): Response
    {
        $this->depositPossible = $depositPossible;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Response
    {
        $this->message = $message;
        return $this;
    }
}

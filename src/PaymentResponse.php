<?php

namespace Antonowano\QiwiTopup;

class PaymentResponse
{
    /** @var int|null */
    private $status;

    /** @var bool|null */
    private $finalStatus;

    /** @var int|null */
    private $transactionId;

    /** @var int|null */
    private $transactionNumber;

    /** @var \DateTime|null */
    private $transactionDate;

    /** @var float|null */
    private $fromAmount;

    /** @var int|null */
    private $fromCcy;

    /** @var int|null */
    private $fromServiceId;

    /** @var float|null */
    private $toAmount;

    /** @var int|null */
    private $toServiceId;

    /** @var int|null */
    private $toCcy;

    /** @var string|null */
    private $toAccountNumber;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getFinalStatus(): ?bool
    {
        return $this->finalStatus;
    }

    public function setFinalStatus(?bool $finalStatus): self
    {
        $this->finalStatus = $finalStatus;
        return $this;
    }

    public function getTransactionId(): ?int
    {
        return $this->transactionId;
    }

    public function setTransactionId(?int $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getTransactionNumber(): ?int
    {
        return $this->transactionNumber;
    }

    public function setTransactionNumber(?int $transactionNumber): self
    {
        $this->transactionNumber = $transactionNumber;
        return $this;
    }

    public function getTransactionDate(): ?\DateTime
    {
        return $this->transactionDate;
    }

    public function setTransactionDate(?\DateTime $transactionDate): self
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    public function getFromAmount(): ?float
    {
        return $this->fromAmount;
    }

    public function setFromAmount(?float $fromAmount): self
    {
        $this->fromAmount = $fromAmount;
        return $this;
    }

    public function getFromCcy(): ?int
    {
        return $this->fromCcy;
    }

    public function setFromCcy(?int $fromCcy): self
    {
        $this->fromCcy = $fromCcy;
        return $this;
    }

    public function getFromServiceId(): ?int
    {
        return $this->fromServiceId;
    }

    public function setFromServiceId(?int $fromServiceId): self
    {
        $this->fromServiceId = $fromServiceId;
        return $this;
    }

    public function getToAmount(): ?float
    {
        return $this->toAmount;
    }

    public function setToAmount(?float $toAmount): self
    {
        $this->toAmount = $toAmount;
        return $this;
    }

    public function getToServiceId(): ?int
    {
        return $this->toServiceId;
    }

    public function setToServiceId(?int $toServiceId): self
    {
        $this->toServiceId = $toServiceId;
        return $this;
    }

    public function getToCcy(): ?int
    {
        return $this->toCcy;
    }

    public function setToCcy(?int $toCcy): self
    {
        $this->toCcy = $toCcy;
        return $this;
    }

    public function getToAccountNumber(): ?string
    {
        return $this->toAccountNumber;
    }

    public function setToAccountNumber(?string $toAccountNumber): self
    {
        $this->toAccountNumber = $toAccountNumber;
        return $this;
    }
}

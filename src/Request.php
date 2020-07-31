<?php

namespace Antonowano\QiwiTopup;

class Request
{
    /** @var string|null */
    private $requestType;

    /** @var int|null */
    private $terminalId;

    /** @var string|null */
    private $password;

    /** @var int|null */
    private $transactionNumber;

    /** @var int|null */
    private $fromCcy;

    /** @var int|null */
    private $fromServiceId;

    /** @var float|null */
    private $toAmount;

    /** @var int|null */
    private $toCcy;

    /** @var int|null */
    private $toServiceId;

    /** @var string|null */
    private $toAccountNumber;

    /** @var string|null */
    private $phone;

    /** @var int|null */
    private $incomeWireTransfer;

    /** @var string|null */
    private $groupTag;

    public function getRequestType(): ?string
    {
        return $this->requestType;
    }

    public function setRequestType(string $requestType): self
    {
        $this->requestType = $requestType;
        return $this;
    }

    public function getTerminalId(): ?int
    {
        return $this->terminalId;
    }

    public function setTerminalId(int $terminalId): self
    {
        $this->terminalId = $terminalId;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getTransactionNumber(): ?int
    {
        return $this->transactionNumber;
    }

    public function setTransactionNumber(int $transactionNumber): self
    {
        $this->transactionNumber = $transactionNumber;
        return $this;
    }

    public function getFromCcy(): ?int
    {
        return $this->fromCcy;
    }

    public function setFromCcy(int $fromCcy): self
    {
        $this->fromCcy = $fromCcy;
        return $this;
    }

    public function getFromServiceId(): ?int
    {
        return $this->fromServiceId;
    }

    public function setFromServiceId(int $fromServiceId): self
    {
        $this->fromServiceId = $fromServiceId;
        return $this;
    }

    public function getToAmount(): ?float
    {
        return $this->toAmount;
    }

    public function setToAmount(float $toAmount): self
    {
        $this->toAmount = $toAmount;
        return $this;
    }

    public function getToCcy(): ?int
    {
        return $this->toCcy;
    }

    public function setToCcy(int $toCcy): self
    {
        $this->toCcy = $toCcy;
        return $this;
    }

    public function getToServiceId(): ?int
    {
        return $this->toServiceId;
    }

    public function setToServiceId(int $toServiceId): self
    {
        $this->toServiceId = $toServiceId;
        return $this;
    }

    public function getToAccountNumber(): ?string
    {
        return $this->toAccountNumber;
    }

    public function setToAccountNumber(string $toAccountNumber): self
    {
        $this->toAccountNumber = $toAccountNumber;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getIncomeWireTransfer(): ?int
    {
        return $this->incomeWireTransfer;
    }

    public function setIncomeWireTransfer(int $incomeWireTransfer): self
    {
        $this->incomeWireTransfer = $incomeWireTransfer;
        return $this;
    }

    public function getGroupTag(): ?string
    {
        return $this->groupTag;
    }

    public function setGroupTag(?string $groupTag): self
    {
        $this->groupTag = $groupTag;
        return $this;
    }

    public function hasTagFrom(): bool
    {
        return $this->fromCcy || $this->fromServiceId;
    }

    public function hasTagTo(): bool
    {
        return $this->toAccountNumber || $this->toAmount || $this->toCcy || $this->toServiceId;
    }
}

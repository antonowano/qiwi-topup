<?php

namespace Antonowano\QiwiTopup\Constant;

abstract class PaymentStatuses
{
    public const UNKNOWN_ERROR = -1;
    public const NEED_CONFIRMATION_START = 0;
    public const NEED_CONFIRMATION_END = 49;
    public const PROCESSING_START = 50;
    public const PROCESSING_END = 59;
    public const PROCESSING = 50;
    public const CREDITING = 52;
    public const EXECUTED = 60;
    public const ERROR_START = 100;
    public const NOT_ACCEPTED = 150;
    public const PAY_AUTH_ERROR = 151;
    public const FAILED_OR_CANCELED = 160;
}

<?php

namespace Antonowano\QiwiTopup\Constant;

abstract class PaymentStatuses
{
    public const UNKNOWN_ERROR = -1;
    public const NEED_CONFIRMATION = 49;
    public const PROCESSING = 50;
    public const CREDITING = 52;
    public const EXECUTED = 60;
    public const NOT_ACCEPTED = 150;
    public const PAY_AUTH_ERROR = 151;
    public const FAILED_OR_CANCELED = 160;
}

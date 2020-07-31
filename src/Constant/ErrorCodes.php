<?php

namespace Antonowano\QiwiTopup\Constant;

abstract class ErrorCodes
{
    public const NO_ERROR = 0;
    public const REPEAT = 13;
    public const ERROR_AUTH = 150;
    public const UNKNOWN_ERROR = 300;
    public const IP_BLOCKING = 339;
    public const BAD_SERVICE = 155;
    public const BAD_IDENT = 204;
    public const TRANSACTION_NUMBER_EXISTS = 215;
    public const NO_MONEY = 220;
    public const AMOUNT_LIMIT = 242;
    public const IS_BLOCKED = 316;
}

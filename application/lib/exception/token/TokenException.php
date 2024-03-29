<?php

namespace app\lib\exception\token;

use SoloCms\exception\BaseException;

class TokenException extends BaseException
{
    public $code = 401;
    public $msg  = 'Token已过期或无效Token';
    public $errorCode = '10001';
}
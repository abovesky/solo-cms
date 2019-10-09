<?php

namespace app\lib\exception\file;

use SoloCms\exception\BaseException;

class FileException extends BaseException
{
    public $code = 413;
    public $msg  = '文件体积过大';
    public $error_code = '60000';
}

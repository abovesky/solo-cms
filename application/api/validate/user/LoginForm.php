<?php

namespace app\api\validate\user;

use SoloCms\validate\BaseValidate;

class LoginForm extends BaseValidate
{
    protected $rule = [
        'nickname' => 'require',
        'password' => 'require',
    ];

    protected $message = [
        'nickname' => '用户名不能为空',
        'password' => '密码不能为空'
    ];
}
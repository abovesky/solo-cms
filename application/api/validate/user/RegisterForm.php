<?php

namespace app\api\validate\user;

use SoloCms\validate\BaseValidate;

class RegisterForm extends BaseValidate
{
    protected $rule = [
        'password' => 'require|confirm:confirm_password',
        'confirm_password' => 'require',
        'nickname' => 'require|length:2,10',
        'group_id' => 'require|>:0',
        'email' => 'email'
    ];
}
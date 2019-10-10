<?php

namespace app\api\controller\cms;

//use app\api\validate\user\TokenCreate;  # 开启注释验证器以后，本行可以去掉，这里做更替说明
use app\lib\token\Token as TokenService;
use SoloCms\model\Admin;
use think\facade\Hook;
use think\Request;

class Token extends Controller
{
    /**
     * 创建令牌
     * @param Request $request
     * @validate('TokenCreate')
     * @return array
     * @throws \think\Exception
     */
    public function create(Request $request)
    {
//        (new TokenCreate())->goCheck();  # 开启注释验证器以后，本行可以去掉，这里做更替说明
        $params = $request->post();

        $user = Admin::verify($params['nickname'], $params['password']);
        $result = TokenService::getToken($user);

        Hook::listen('logger', array('uid' => $user->id, 'nickname' => $user->nickname, 'msg' => '登陆成功获取了令牌'));

        return $result;
    }

    /**
     * 刷新令牌
     * @return array
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function refresh()
    {
        $result = TokenService::refreshToken();
        return $result;
    }

}

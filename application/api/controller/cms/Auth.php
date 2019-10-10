<?php

namespace app\api\controller\cms;

use app\lib\auth\AuthMap;
use SoloCms\model\AdminAuth;
use think\facade\Hook;
use think\Request;

class Auth
{
    /**
     * @auth('查询所有可分配的权限','管理员','hidden')
     * @return array
     * @throws \ReflectionException
     * @throws \WangYu\exception\ReflexException
     */
    public function getAuths()
    {
        $result = (new AuthMap())->run();

        return $result;
    }

    /**
     * @auth('删除多个权限','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function removeAuths(Request $request)
    {
        $params = $request->post();

        AdminAuth::where(['group_id' => $params['group_id'], 'auth' => $params['auths']])
            ->delete();
        return writeJson(201, '', '删除权限成功');
    }

    /**
     * @auth('分配多个权限','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dispatchAuths(Request $request)
    {
        $params = $request->post();

        AdminAuth::dispatchAuths($params);
        Hook::listen('logger', '修改了id为' . $params['group_id'] . '分组的权限');
        return writeJson(201, '', '分配权限成功');
    }
}
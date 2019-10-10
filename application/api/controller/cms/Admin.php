<?php

namespace app\api\controller\cms;

//use app\api\validate\user\RegisterForm; # 开启注释验证器以后，本行可以去掉，这里做更替说明
use app\lib\token\Token as TokenService;
use SoloCms\model\Admin as AdminModel;
use think\App;
use think\Controller;
use think\facade\Hook;
use think\Request;

class Admin extends Controller
{
    /**
     * @return mixed
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function getInfo()
    {
        $user = TokenService::getCurrentUser();
        return $user;
    }

    /**
     * 查询自己拥有的权限
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function getAllowedApis()
    {
        $uid = TokenService::getCurrentUID();
        $result = AdminModel::getUserByUID($uid);
        return $result;
    }

    /**
     * @param Request $request
     * @param ('url','头像url','require|url')
     * @return \think\response\Json
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function updateAvatar(Request $request)
    {
        $url = $request->put('avatar');
        $uid = TokenService::getCurrentUID();
        AdminModel::updateUserAvatar($uid, $url);

        return writeJson(201, '', '更新头像成功');
    }

    /**
     * 配置hidden后，这个权限信息不会挂载到权限图，获取所有可分配的权限时不会显示这个权限
     * @auth('查询所有用户','管理员','hidden')
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function getUsers(Request $request)
    {
        $params = $request->get();

        $result = AdminModel::getAdminUsers($params);
        return $result;
    }

    /**
     * @auth('修改用户密码','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \SoloCms\exception\user\UserException
     */
    public function changePassword(Request $request)
    {
        $params = $request->param();

        AdminModel::resetPassword($params);
        return writeJson(201, '', '密码修改成功');
    }

    /**
     * @auth('创建用户','管理员','hidden')
     * @param Request $request
     * @validate('RegisterForm')
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createUser(Request $request)
    {
//        (new RegisterForm())->goCheck(); # 开启注释验证器以后，本行可以去掉，这里做更替说明

        $params = $request->post();
        AdminModel::createUser($params);

        Hook::listen('logger', '创建了一个管理员');

        return writeJson(201, '', '创建成功');
    }

    /**
     * @auth('删除用户','管理员','hidden')
     * @param $uid
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function deleteUser($uid)
    {
        AdminModel::deleteUser($uid);
        Hook::listen('logger', '删除了id为' . $uid . '的管理员');
        return writeJson(201, '', '操作成功');
    }

    /**
     * @auth('管理员更新用户信息','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \SoloCms\exception\user\UserException
     */
    public function updateUser(Request $request)
    {
        $params = $request->param();
        AdminModel::updateUser($params);

        return writeJson(201, '', '操作成功');
    }

}

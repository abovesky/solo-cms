<?php

namespace app\api\controller\cms;

use app\lib\auth\AuthMap;
use SoloCms\exception\group\GroupException;
use SoloCms\model\AdminAuth;
use SoloCms\model\AdminGroup;
use SoloCms\model\Admin as AdminModel;
use think\facade\Hook;
use think\Request;

class Group
{
    /**
     * @auth('查询所有权限组','管理员','hidden')
     * @return mixed
     */
    public function getGroups()
    {
        $result = AdminGroup::all();

        return $result;
    }

    /**
     * @auth('查询一个权限组及其权限','管理员','hidden')
     * @param $id
     * @return array|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws GroupException
     */
    public function getGroup($id)
    {
        $result = AdminGroup::getGroupByID($id);

        return $result;
    }


    /**
     * @auth('删除一个权限组','管理员','hidden')
     * @param $id
     * @return \think\response\Json
     * @throws GroupException
     */
    public function deleteGroup($id)
    {
        //查询当前权限组下是否存在用户
        $hasUser = AdminModel::get(['group_id'=>$id]);
        if($hasUser)
        {
            throw new GroupException([
                'code' => 412,
                'msg' => '分组下存在用户，删除分组失败',
                'error_code' => 30005
            ]);
        }
        AdminGroup::deleteGroupAuth($id);
        Hook::listen('logger', '删除了权限组id为' . $id . '的权限组');
        return writeJson(201, '', '删除分组成功');
    }

    /**
     * @auth('新建权限组','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws GroupException
     */
    public function createGroup(Request $request)
    {
        $params = $request->post();

        AdminGroup::createGroup($params);
        return writeJson(201, '', '成功');
    }

    /**
     * @auth('更新一个权限组','管理员','hidden')
     * @param Request $request
     * @param $id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function updateGroup(Request $request, $id)
    {
        $params = $request->put();

        $group = AdminGroup::find($id);
        if (!$group) {
            throw new GroupException([
                'code' => 404,
                'msg' => '指定的分组不存在',
                'errorCode' => 30003
            ]);
        }
        $group->save($params);
        return writeJson(201, '', '更新分组成功');
    }

}
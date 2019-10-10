<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::group('', function () {
    Route::group('cms', function () {
        // 授权相关
        Route::group('token', function () {
            // 创建令牌
            Route::post('create', 'api/cms.Token/create');
            // 刷新令牌
            Route::get('refresh', 'api/cms.Token/refresh');
        });
        // 管理员相关
        Route::group('admin', function () {
            // 查询自己拥有的权限
            Route::get('auths', 'api/cms.Admin/getAllowedApis');
            // 添加管理员
            Route::post('', 'api/cms.Admin/createUser');
            // 当前管理员信息
            Route::get('info','api/cms.Admin/getInfo');
            // 管理员列表
            Route::get('list', 'api/cms.Admin/getUsers');
            // 修改管理员密码
            Route::put('password/:uid', 'api/cms.Admin/changePassword');
            // 删除一个管理员
            Route::delete(':uid', 'api/cms.Admin/deleteUser');
            // 更新管理员信息
            Route::put(':uid', 'api/cms.Admin/updateUser');
            // 更新管理员头像
            Route::put('avatar','api/cms.Admin/updateAvatar');
        });
        // 分组相关
        Route::group('group', function () {
            // 分组列表
            Route::get('list', 'api/cms.Group/getGroups');
            // 查询一个分组及其权限
            Route::get(':id', 'api/cms.Group/getGroup');
            // 删除分组
            Route::delete(':id', 'api/cms.Group/deleteGroup');
            // 更新分组
            Route::put(':id', 'api/cms.Group/updateGroup');
            // 新建分组
            Route::post('', 'api/cms.Group/createGroup');
        });

        // 权限相关
        Route::group('auth', function () {
            // 查询所有可分配的权限
            Route::get('list', 'api/cms.Auth/getAuths');
            // 删除多个权限
            Route::delete('remove', 'api/cms.Auth/removeAuths');
            // 分配多个权限
            Route::post('dispatch', 'api/cms.Auth/dispatchAuths');
        });

        // 日志类接口
        Route::get('log/', 'api/cms.Log/getLogs');
        Route::get('log/users', 'api/cms.Log/getUsers');
        Route::get('log/search', 'api/cms.Log/getUserLogs');

        //上传文件类接口
        Route::post('file/','api/cms.File/postFile');
    });
    Route::group('v1', function () {
        // 查询所有图书
        Route::get('book/', 'api/v1.Book/getBooks');
        // 新建图书
        Route::post('book/', 'api/v1.Book/create');
        // 查询指定bid的图书
        Route::get('book/:bid', 'api/v1.Book/getBook');
        // 搜索图书

        // 更新图书
        Route::put('book/:bid', 'api/v1.Book/update');
        // 删除图书
        Route::delete('book/:bid', 'api/v1.Book/delete');
    });
})->middleware(['Auth','ReflexValidate'])->allowCrossDomain();

